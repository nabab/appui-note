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
      source: {
        type: Array,
        required: true
      },
      showGuide: {
        type: Boolean
      },
      position: {
        type: Number
      }
    },
    data(){
      return {
        currentType: '',
        isMoving: false,
        currentEdited: -1,
        nextEdited: -1,
        realRowSelected: -1,
        realSourceArray: [],
        editedSource: null,
        data: {
          type: 'text',
          content: ''
        },
        types: types
      };
    },
    methods: {
      changeEdited(idx) {
        this.currentEdited = idx;
        this.$emit('changes', {
          currentEdited: this.currentEdited
        });
      },
      onClose() {
        let form = this.getRef('form');
        if (form.dirty) {
          if (form.isValid()) {
            this.confirm(bbn._("Do you want to save your changes?"), () => {
              form.submit();
              this.currentEdited = idx;
            }, () => {
              this.currentEdited = idx;
            });
          }
          else {
            this.confirm(bbn._("Do you want to abandon your changes?"), () => {
              this.currentEdited = idx
            });
          }
        }
        else {
          this.currentEdited = idx
        }
      },
      updateSelected() {
        if (this.source[this.currentEdited]) {
          let r = this.source[this.currentEdited];
          if (r.type === 'container') {
            this.realSourceArray = r.items;
            let ct = this.getRef('block' + this.currentEdited);
            this.realRowSelected = ct ? ct.currentItemSelected : -1;
            this.editedSource = r.items[this.realRowSelected] || null;
          }
          else {
            this.realSourceArray = this.source;
            this.realRowSelected = this.currentEdited;
            this.editedSource = this.source[this.currentEdited] || null;
          }
        }
        else {
          this.realSourceArray = this.source;
          this.realRowSelected = -1;
          this.editedSource = null;
        }
      },
      onDrag() {
        this.$emit('dragoverdroppable', ...arguments);
      }
    },
    watch: {
      'editedSource.type'(v, ov) {
        bbn.fn.log(v, ov, '???');
        let tmp = this.editedSource;
        if (v && (ov !== undefined) && this.editedSource && this.realSourceArray.length) {
          let cfg = bbn.fn.getField(types, 'default', {value:v});
          if (cfg) {
            for (let n in cfg) {
              if ((n !== 'type') && (tmp[n] === undefined)) {
                this.$set(tmp, n, cfg[n]);
              }
              else {
                tmp[n] = cfg[n];
              }
            }
            for (let n in tmp) {
              if (cfg[n] === undefined && (n !== 'type')) {
                delete tmp[n];
              }
            }
          }
        }
      },
      currentEdited(v) {
        this.editedSource = null;
        if (this.source[v]) {
          this.currentType = this.source[v].type || 'text';
        }
        this.$nextTick(() => {
          this.updateSelected();
        });
      },
      showHover() {
        bbn.fn.log("show hover", this.showHover);
      },
      position() {
        //bbn.fn.log('position', this.position);
      }
    },
  };
})();