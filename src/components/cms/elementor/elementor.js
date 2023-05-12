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
      }
    },
    data(){
      return {
        currentEditingKey: -1,
        types: types,
        indexInContainer: -1,
        dragData: bbn.fn.map(this.source, (cfg, i) => {
          return {data: bbn.fn.extend({}, cfg, {inside: true, index: i}), mode: 'self'};
        }),
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
        this.currentEditingKey = -1;
        this.indexInContainer = -1;
        this.$emit('unselect');
      },
      onDragStart(ev){
        this.currentDragging = true;
      },
      onDragEnd(ev){
        this.currentDragging = false;
      },
      onDrop(ev){
        this.onDragEnd();
        let fromData = bbn.fn.clone(ev.detail.from.data);
        if (fromData?.type === 'elementor') {
          let toData = bbn.fn.clone(ev.detail.to.data);
          bbn.fn.log('onDrop', fromData, toData)
          let oldIndex = fromData.index;
          let newIndex = toData.index;
          if ((oldIndex === undefined)
            || (newIndex < oldIndex)
            || (newIndex > (oldIndex + 1))
          ) {
            if (oldIndex !== undefined) {
              this.source.splice(fromData.index, 1);
              if (oldIndex < newIndex) {
                newIndex--;
              }
            }
            else {
              bbn.fn.iterate(fromData.cfg || {}, (v, k) => fromData.source[k] = v);
              fromData.source._elementor = {
                key: bbn.fn.randomString(32, 32)
              }
            }
            this.source.splice(newIndex, 0, fromData.source);
          }
        }
      },
      /*
      Emit the current source object (from a block) to the editor component.
      */
      selectBlock(key, source) {
        bbn.fn.log('selectBlock')
        this.currentEditingKey = key;
        this.indexInContainer = -1;
        this.$emit('changes', key, source);
      },
      /*
      Emit the current source object (from a container) to the editor component.
      */
      selectContainer(key, source, indexInContainer) {
        this.currentEditingKey = key;
        this.indexInContainer = indexInContainer;
        this.$emit('changes', key, source, indexInContainer);
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
              this.currentEditingKey = idx;
            }, () => {
              this.currentEditingKey = idx;
            });
          }
          else {
            this.confirm(bbn._("Do you want to abandon your changes?"), () => {
              this.currentEditingKey = idx;
            });
          }
        }
        else {
          this.currentEditingKey = idx;
        }
      },
      
    },
    components: {
      guide: {
        namme: 'guide',
        template: `
<div class="appui-note-cms-elementor-guide bbn-vspadded bbn-w-100"
     @mouseover="isOver = true"
     @mouseleave="isOver = false"
     @drop="e => $emit('drop', e)">
  <div class="bbn-w-100"
       :style="{visibility: isVisible ? 'visible' : 'hidden'}"/>
</div>
        `,
        props: {
          visible: {
            type: Boolean,
            default: false
          },
          force: {
            type: Boolean,
            default: false
          }
        },
        data(){
          return {
            isOver: false
          }
        },
        computed: {
          isVisible(){
            return this.visible && (this.force || this.isOver);
          }
        }
      }
    }
  };
})();