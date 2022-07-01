// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent],
    props: {
      source: {
        type: Object
      },
      action: {
        type: String,
        default: appui.plugins['appui-note'] + '/' + 'cms/actions/save'
      },
      prefix: {
        type: String
      }
    },
    data(){
      return {
        data: null,
        oData: JSON.stringify(this.source),
        ready: false,
        root: appui.plugins['appui-note'] + '/'
      };
    },
    computed: {
      types() {
        return this.data ? this.data.types_notes : [];
      },
      typeNote() {
        if (this.source.id_type) {
          return bbn.fn.getRow(this.types, {id: this.source.id_type});
        }

        return {};
      },
      isChanged(){
        return JSON.stringify(this.source) !== this.oData;
      },
      contextSource(){
        let ed = this.getRef('editor');
        let newBlock = {
          type: 'text',
          text: ''
        };
        let res = [{
          text: bbn._("Add a block at the start"),
          icon: 'nf nf-mdi-file_document_box',
          action: () => {
            this.source.items.splice(0, 0, newBlock);
            this.$nextTick(() => {
              this.getRef('editor').currentEdited = 0;
            })
          }
        }, {
          text: bbn._("Add a container at the start"),
          icon: 'nf nf-mdi-table_row',
          action: () => {
            this.source.items.splice(0, 0, {
              type: 'container',
              items: []
            });
            this.$nextTick(() => {
              this.getRef('editor').currentEdited = 0;
            })
          }
        }];
        if (this.source.items.length > 0) {
          res.push({
            text: bbn._("Add a block at the end"),
            icon: 'nf nf-fa-plus',
            action: () => {
              let idx = this.source.items.length;
              this.source.items.push(newBlock);
              this.$nextTick(() => {
                this.getRef('editor').currentEdited = idx;
              })
            }
          });
        }
        if (ed) {
          if (ed.currentEdited > 1) {
            res.push({
              text: bbn._("Add a block before the selected block"),
              icon: 'nf nf-fa-plus',
              action: () => {
                this.source.items.splice(ed.currentEdited, 0, newBlock);
              }
            });
          }
          if (ed.currentEdited < (this.source.items.length -2)) {
            res.push({
              text: bbn._("Add a block after the selected block"),
              icon: 'nf nf-fa-plus',
              action: () => {
                this.source.items.splice(ed.currentEdited + 1, 0, newBlock);
                this.$nextTick(() => {
                  this.getRef('editor').currentEdited++;
                })
              }
            });
          }
        }
        return res;
      }
    },
    methods: {
      onSave(d) {
        this.oData = JSON.stringify(this.source);
        appui.success(bbn._("Saved"))
      },
      clearCache(){
        this.confirm(bbn._('Are you sure?'), () => {
          this.post(this.root + 'cms/actions/clear_cache', {id: this.source.id}, d => {
            if (d.success) {
              appui.success();
            }
            else {
              appui.error();
            }
          })
        });
      }
    },
    mounted() {
      this.data = this.closest('bbn-router').closest('bbn-container').source;
    }
  }
})();