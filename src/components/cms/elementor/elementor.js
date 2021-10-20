// Javascript Document

(() => {
  return {
    props: {
      source: {
        type: Array,
   			required: true
      },
    },
    data(){
      return {
        currentType: 'text',
        isMoving: false,
        currentEdited: -1,
        nextEdited: -1,
        types: [
          {
            text: bbn._("Title"),
            value: 'title',
            default: {
            	tag: 'h1',
              content: '',
              color: '#000000',
              align: 'left',
              decoration: 'none',
              italic: false,
              hr: null
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
	          }
          }, {
            text: bbn._("Space"),
            value: 'space',
            default: {
              size: '1em'
	          }
          }, {
            text: bbn._("Rich text (HTML)"),
            value: 'html',
            default: {
              content: ''
	          }
          }, {
            text: bbn._("Image"),
            value: 'image',
            default: {
              src: ''
            }
          }, {
            text: bbn._("Carousel"),
            value: 'carousel',
            default: {
              source: []
            }
          }, {
            text: bbn._("Gallery"),
            value: 'gallery',
            default: {
              source: []
            }
          }, {
            text: bbn._("Video"),
            value: 'video',
            default: {
              src: '',
              autoplay: false,
              muted: false,
              controls: false,
              loop: false,
              style: {
                width: '100%',
                height: '100%'
              },
              align: 'center'
            }
          }
        ],
        data: {
          type: 'text',
          content: ''
        }
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
      }
    },
    watch: {
      currentType(v) {
        let newCfg = bbn.fn.clone(bbn.fn.getRow(this.types, {value:v}).default);
        if (newCfg && this.source[this.currentEdited]) {
          for (let n in newCfg) {
            if (this.source[this.currentEdited][n] !== undefined) {
              newCfg[n] = this.source[this.currentEdited][n];
            }
          }
          newCfg.type = v;
          this.source.splice(this.currentEdited, 1, newCfg)
        }
      },
    	currentEdited(v) {
        if (this.isMoving) {
          return;
        }
        if (v === -1) {
          this.currentType = 'text';
          return;
        }

        if (this.nextEdited === v) {
          this.nextEdited = -1;
          //this.getRef('toolbar').updateSlot();
        }
        else {
          this.nextEdited = v;
          this.currentEdited = -1;
          setTimeout(() => {
            this.currentEdited = this.nextEdited;
            this.currentType = this.source[this.currentEdited].type;
          }, 100)
        }
      }
	  }
  };
})();