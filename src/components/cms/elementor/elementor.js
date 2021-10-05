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
        isMoving: false,
        currentEdited: -1,
        nextEdited: -1,
        cfgs: this.source,
        types: [
          {
            text: bbn._("Title"),
            value: 'title'
          }, {
            text: bbn._("Text"),
            value: 'text'
          }, {
            text: bbn._("Line"),
            value: 'line'
          }, {
            text: bbn._("Space"),
            value: 'space'
          }, {
            text: bbn._("Rich text (HTML)"),
            value: 'html'
          }, {
            text: bbn._("Image"),
            value: 'image'
          }, {
            text: bbn._("Carousel"),
            value: 'carousel'
          }, {
            text: bbn._("Gallery"),
            value: 'gallery'
          }, {
            text: bbn._("Video"),
            value: 'video'
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
            disabled: this.currentEdited >= this.cfgs.length - 1,
            action: () => {
              this.move('down');
            }
          });
          res.push({
            icon: 'nf nf-mdi-chevron_double_down',
            notext: true,
            text: bbn._("Move to end"),
            disabled: this.currentEdited >= this.cfgs.length - 2,
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
      contextSource(){
        return [{
          text: bbn._("Add a block before"),
          action: () => {
            let newBlock = {
              type: 'text',
              content: ''
            };
            this.cfgs.splice(this.currentEdited, 0, newBlock);
          }
        }, {
          text: bbn._("Add a block after"),
          action: () => {
            let newBlock = {
              type: 'text',
              content: ''
            };

            if (this.currentEdited === this.cfgs.length - 1) {
              this.cfgs.push(newBlock);
            }
            else {
              this.cfgs.splice(this.currentEdited + 1, 0, newBlock);
            }
          }
        }];
      },
      isEditorOverlay(){
        if (this.currentEdited === -1) {
          return false;
        }

        return ['html', 'markdown', 'gallery'].includes(this.cfgs[this.currentEdited].type);
      },
      isEditorScrollable(){
        if (this.currentEdited === -1) {
          return false;
        }

        return ['html', 'markdown', 'gallery'].includes(this.cfgs[this.currentEdited].type);
      }
    },
    methods: {
      move(dir, idx) {
        let isUp = dir.toLowerCase() === 'up';
        if (idx === true) {
          bbn.fn.move(this.cfgs, this.currentEdited, isUp ? 0 : this.cfgs.length - 1);
          this.currentEdited = isUp ? 0 : this.cfgs.length - 1;
        }
        else if (idx === undefined) {
          bbn.fn.move(this.cfgs, this.currentEdited, isUp ? this.currentEdited - 1 : this.currentEdited + 1);
          this.currentEdited = isUp ? this.currentEdited - 1 : this.currentEdited + 1;
        }
        else if (this.cfgs[idx]) {
          bbn.fn.move(this.cfgs, this.currentEdited, idx);
          this.currentEdited = idx;
        }
        setTimeout(() => {
          this.getRef('block' + this.currentEdited).selected = true;
          this.getRef('leftPane').getRef('scroll').scrollTo(null, this.getRef('block' + this.currentEdited).$el);
        }, 500)
      }
    },
    mounted(){
      
    },
    watch: {
    	currentEdited(v) {
        if (this.isMoving) {
          return;
        }
        if (v === -1) {
          return;
        }

        if (this.nextEdited === v) {
          this.nextEdited = -1;
          this.getRef('toolbar').updateSlot();
        }
        else {
          this.nextEdited = v;
          this.currentEdited = -1;
          setTimeout(() => {
            this.currentEdited = this.nextEdited;
          }, 100)
        }
      }
	  }
  };
})();