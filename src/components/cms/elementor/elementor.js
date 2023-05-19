// Javascript Document

(() => {
  const types = [
    {
      text: bbn._("Title"),
      value: 'title',
      default: {
        tag: 'h1',
        content: '',
        align: 'left',
        hr: null,
        style: {
          'text-decoration': 'none',
          'font-style': 'normal',
          color: '#000000'
        }
      }
    }, {
      text: bbn._("Text"),
      value: 'text',
      default: {
        content: ''
      }
    }, {
      text: bbn._("Line"),
      value: 'line',
      default: {
        hr: null,
        align: 'center',
        style: {
          width: '100%',
          height: '0px'
        }
      }
    }, {
      text: bbn._("Space"),
      value: 'space',
      default: {
        size: '1em'
      }
    }, {
      text: bbn._("Button"),
      value: 'button',
      default: {
        url: '',
        content: '',
        align: 'center',
        style: {}
      }
    },{
      text: bbn._("Rich text (HTML)"),
      value: 'html',
      default: {
        content: '',
        align: 'left',
        style: {}
      }
    }, {
      text: bbn._("Image"),
      value: 'image',
      default: {
        source: '',
        alt: '',
        href: '',
        caption: '',
        details_title: '',
        details: '',
        style: {
          width: '100%',
          height: '100%'
        },
        align: 'center'
      }
    },{
      text: bbn._("Image Text"),
      value: 'imagetext',
      default: {
        source: '',
        alt: '',
        href: '',
        caption: '',
        details_title: '',
        details: '',
        style: {
          width: '100%',
          height: '100%'
        },
        align: 'center'
      }
    }, {
      text: bbn._("Carousel"),
      value: 'carousel',
      default: {
        source: '',
        autoplay: 1,
        arrows: 0,
        preview: 1,
        loop: 1,
        info: 1,
        style: {
          width: '100%',
          height: '300px'
        },
        align: 'center'
      }
    }, {
      text: bbn._("Slider"),
      value: 'slider',
      default: {
        source: '',
        autoplay: 1,
        arrows: 0,
        preview: 1,
        loop: 1,
        info: 1,
        style: {
          width: '100%',
        },
        align: 'center'
      }
    }, {
      text: bbn._("Gallery"),
      value: 'gallery',
      default: {
        source: '',
        scrollable: 0,
        pageable: 0,
        pager: 0,
        zoomable: 0,
        resizable: 0,
        toolbar: 0,
        crop: 1,
        style: {
          width: '100%',
          height: '100%'
        },
        align: 'center',
        imageWidth: 33
      }
    }, {
      text: bbn._("Video"),
      value: 'video',
      default: {
        source: '',
        autoplay: 0,
        muted: 0,
        controls: 0,
        loop: 0,
        style: {
          width: '100%',
          height: '100%'
        },
        align: 'center'
      }
    }, {
      text: bbn._("Feature"),
      value: 'feature',
      default: {}
    }, {
      text: bbn._("Product"),
      value: 'product',
      default: {
        source: '',
        showType: true,
        style: {
          width: '100%',
          height: '100%'
        },
        align: 'center'
      }
    }
  ];

  return {
    props: {
      allBlocks: {
        type: Array
      },
      source: {
        type: Array,
        required: true
      },
      showGuide: {
        type: Boolean
      },
      position: {
        type: Number
      },
      preview: {
        type: Boolean,
        default: false
      },
      dragging: {
        type: Boolean,
        default: false
      },
      itemSelected: {
        type: String
      }
    },
    data(){
      return {
        types: types,
        editor: {},
        currentDragging: false
      };
    },
    computed: {
      isDragging(){
        return !!this.dragging || !!this.currentDragging;
      }
    },
    methods: {
      unselect() {
        this.$emit('unselect');
      },
      getDraggableData(index, src, type){
        if (!this.preview) {
          return {
            data: {
              type: type,
              index: index,
              source: src,
              parentUid: this._uid,
              parentSource: this.source
            },
            mode: 'clone'
          };
        }

        return false;
      },
      onDragStart(ev){
        this.currentDragging = true;
      },
      onDragEnd(ev){
        this.currentDragging = false;
      },
      onDrop(ev){
        this.onDragEnd();
        let fromData = ev.detail.from.data;
        if (!!fromData.type && (fromData.source !== undefined)) {
          let newSource = bbn.fn.clone(fromData.source);
          let toData = ev.detail.to.data;
          let oldIndex = null;
          let newIndex = toData.index;
          switch (fromData.type) {
            case 'cmsDropper':
              bbn.fn.iterate(fromData.cfg || {}, (v, k) => newSource[k] = v);
              newSource._elementor = this.editor.getElementorDefaultObj();
              break;
            case 'cmsContainerBlock':
            case 'cmsBlock':
            case 'cmsContainer':
              oldIndex = fromData.index;
              if ((fromData.parentSource !== undefined)
                && ((fromData.parentUid !== this._uid)
                  || ((newIndex < oldIndex)
                    || (newIndex > (oldIndex + 1))))
              ) {
                fromData.parentSource.splice(oldIndex, 1);
              }
              break;
            default:
              return;
          }
          if (toData.replace) {
            let ns = bbn.fn.extend(
              true,
              {
                type: 'container',
                _elementor: this.editor.getElementorDefaultObj()
              },
              bbn.fn.getRow(appui.cms.blocks, 'code', 'container').configuration
            );
            ns.items.push(toData.source, newSource);
            newSource = ns;
          }
          if (bbn.fn.isNull(oldIndex)
            || ((fromData.parentSource !== undefined)
              && ((fromData.parentUid !== this._uid)
                || ((newIndex < oldIndex)
                  || (newIndex > (oldIndex + 1)))))
          ) {
            this.source.splice(newIndex, toData.replace ? 1 : 0, newSource);
          }
        }
      },
      /*
      Emit the current source object (from a block) to the editor component.
      */
      selectBlock(key, source, items) {
        this.$emit('changes', key, source, items);
      },
      /*
      Ask the user to save changes and submit the form
      */
      onClose() {
        let form = this.getRef('form');
        if (form.dirty) {
          if (form.isValid()) {
            this.confirm(bbn._("Do you want to save your changes?"), () => {
              form.submit();
              //this.currentEditingKey = idx;
            }, () => {
              //this.currentEditingKey = idx;
            });
          }
          else {
            this.confirm(bbn._("Do you want to abandon your changes?"), () => {
              //this.currentEditingKey = idx;
            });
          }
        }
        else {
          //this.currentEditingKey = idx;
        }
      }
    },
    mounted(){
      this.$set(this, 'editor', this.closest('appui-note-cms-editor'));
    }
  };
})();