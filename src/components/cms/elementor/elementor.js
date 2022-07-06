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
        style: {
          width: '100%',
          height: '100%'
        },
        align: 'center',
        imageWidth: 150
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
    }
  ];

  return {
    props: {
      source: {
        type: Array,
        required: true
      },
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
    computed: {
      toolbarSource(){
        let res = [];
        if (this.currentEdited !== -1) {
          res.push({});
          res.push({
            icon: 'nf nf-mdi-chevron_double_up',
            notext: true,
            text: bbn._("Move to start"),
            disabled: this.currentEdited <= 1,
            action: () => {
              this.move('up', true);
            }
          });
          res.push({
            icon: 'nf nf-mdi-chevron_up',
            notext: true,
            text: bbn._("Move up"),
            disabled: !this.currentEdited,
            action: () => {
              this.move('up');
            }
          });
          res.push({
            icon: 'nf nf-mdi-chevron_down',
            notext: true,
            text: bbn._("Move down"),
            disabled: this.currentEdited >= this.source.length - 1,
            action: () => {
              this.move('down');
            }
          });
          res.push({
            icon: 'nf nf-mdi-chevron_double_down',
            notext: true,
            text: bbn._("Move to end"),
            disabled: this.currentEdited >= this.source.length - 2,
            action: () => {
              this.move('down', true);
            }
          });
          res.push({
            icon: 'nf nf-fa-trash',
            notext: true,
            text: bbn._("Delete the block"),
            end: true,
            action: () => {
              this.deleteBlock();
            }
          });
        }
        /*
          <div class="bbn-flex-fill bbn-r bbn-h-100">
            <div class="bbn-iblock bbn-nowrap">
              <div class="bbn-iblock">
                <bbn-button icon="nf nf-fa-check"
                            :notext="true"
                            text="<?= _("Supprimer ce bloc") ?>"/>
              </div>
              <div class="bbn-iblock bbn-toolbar-separator"> </div>
              <div class="bbn-iblock">
                <bbn-button icon="nf nf-fa-trash"
                            :notext="true"
                            text="<?= _("Supprimer ce bloc") ?>"/>
              </div>
            </div>
          </div>
          */
        return res;
      },
      isEditorOverlay(){
        if (this.currentEdited === -1) {
          return false;
        }

        return ['html', 'markdown', 'gallery'].includes(this.source[this.currentEdited].type);
      },
      isEditorScrollable(){
        if (this.currentEdited === -1) {
          return false;
        }

        return ['html', 'markdown', 'gallery'].includes(this.source[this.currentEdited].type);
      }
    },
    methods: {
      changeEdited(idx) {
        this.currentEdited = idx;
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
      move(dir) {
        let idx;
        switch (dir) {
          case 'top':
            idx = 0;
            break;
          case 'up':
            idx = this.currentEdited - 1;
            break;
          case 'down':
            idx = this.currentEdited + 1;
            break;
          case 'bottom':
            idx = this.source.length - 1;
            break;
        }
        if (this.source[idx]) {
          bbn.fn.move(this.source, this.currentEdited, idx);
          this.currentEdited = idx;
        }

        setTimeout(() => {
          this.getRef('block' + this.currentEdited).selected = true;
          this.getRef('leftPane').getRef('scroll').scrollTo(null, this.getRef('block' + this.currentEdited).$el);
        }, 500)
      },
      deleteCurrentSelected(){
        this.confirm(bbn._("Are you sure you want to delete this block and its content?"), () => {
          let idx = this.currentEdited;
          this.currentEdited = -1;
          this.source.splice(idx, 1);
        })
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
        })

      }
    }
  }
})();