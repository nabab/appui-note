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
      },
      blocks: {
        type: Array,
      }
    },
    data(){
      return {
        data: null,
        oData: JSON.stringify(this.source),
        ready: false,
        root: appui.plugins['appui-note'] + '/',
        showFloater: false,
        showSlider: false,
        showWidgets: false,
        currentEdited: -1,
        editedSource: null,
        mapper: [],
        currentElement: {},
        nextPosition: 0,
        showGuide: false
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
      isChanged() {
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
            });
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
            });
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
              });
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
                });
              }
            });
          }
        }
        return res;
      }
    },
    methods: {
      submit() {
        //remove the object product if the block type is product
        bbn.fn.each(this.source.items, (v, i) => {
          if(v.type === 'container'){
            bbn.fn.each(this.source.items[i].items, (item, idx) => {
              if((item.type === 'product') && this.source.items[i].items[idx].product){
                delete(this.source.items[i].items[idx].product);
              }
            });
          }
          else if ((v.type === 'product' ) && this.source.items[i].product){
            delete(this.source.items[i].product);
          }
        });
      },
      onSave() {
        this.oData = JSON.stringify(this.source);
        appui.success(bbn._("Saved"));
      },
      clearCache() {
        this.showFloater = false;
        this.confirm(bbn._('Are you sure?'), () => {
          this.post(this.root + 'cms/actions/clear_cache', {id: this.source.id}, d => {
            if (d.success) {
              appui.success();
            }
            else {
              appui.error();
            }
          });
        });
      },
      saveSettings() {
        this.$refs.form.submit();
        this.showFloater = false;
      },
      handleChanges(data) {
        this.showWidgets = false;
        this.showSlider = true;
        this.currentEdited = data.currentEdited;
        this.editedSource = this.source.items[data.currentEdited];
        //bbn.fn.log('editedSource', this.editedSource);
      },
      deleteCurrentSelected() {
        this.confirm(bbn._("Are you sure you want to delete this block and its content?"), () => {
          let idx = this.currentEdited;
          this.currentEdited = -1;
          this.source.items.splice(idx, 1);
          this.mapY();
        });
      },
      onDrop(ev) {
        this.showGuide = false;
        const block = ev.detail.from.data;
        bbn.fn.log('block', block);
        if (this.nextPosition == 0) {
          this.source.items.unshift({type: block.type});
        }
        else if (this.nextPosition == -1) {
          this.source.items.push({type: block.type});
        }
        else {
          this.source.items.splice(this.nextPosition, 0, {type: block.type});
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
            idx = this.source.items.length - 1;
            break;
        }
        if (this.source.items[idx]) {
          bbn.fn.move(this.source.items, this.currentEdited, idx);
          this.currentEdited = idx;
        }
      },
      createHTMLElement(html) {
        const placeholder = document.createElement("div");
        placeholder.innerHTML = html;
        const node = placeholder.firstElementChild;
        return node;
      },
      dragOver(e) {
        this.showGuide = true;
        this.currentElement = e.detail.helper.getBoundingClientRect();
        let editor = this.getRef('editor').$el.firstChild;
        this.mapper.map((v, idx, array) => {
          //check if inside
          if ((this.currentElement.y > v.y) && (this.currentElement.y < (v.y + v.height))) {
            //bbn.fn.log("Inside element", idx);
            //bbn.fn.log("value", v);
          }
          //check if at top
          else if (this.currentElement.y < array[0].y) {
            this.nextPosition = 0;
          }
          //check if at last
          else if (this.currentElement.y > (array.at(-1).y + array.at(-1).height)) {
            this.nextPosition = -1;
          }
          //check if between element
          else if ((this.currentElement.y < v.y) && (this.currentElement.y > (array[idx - 1].y + array[idx - 1].height))) {
            this.nextPosition = idx;
          }
        });
      },
      mapY() {
        let editor = this.getRef('editor').$el.firstChild.children;
        bbn.fn.log(editor);
        let arr = [...editor];
        let tmp_arr = [];
        arr.map((v, idx, array) => {
          let detail = v.getBoundingClientRect();
          tmp_arr.push({
            y: detail.y,
            height: detail.height,
            index: idx,
            html: v,
            parent: array[idx].parentNode
          });
        });
        this.mapper = tmp_arr.slice();
      }
    },
    watch: {
      'source.items'() {
        setTimeout(() => {
          this.mapY();
        }, 50);
      },
      mapper() {
        //bbn.fn.log('mapper', this.mapper);
      },
      showHover() {
        //bbn.fn.log('showHover', this.showHover);
      }
    },
    mounted() {
      this.data = this.closest('bbn-router').closest('bbn-container').source;
      this.$set(this.source.items, 0, {type: "title", content: "Bienvenue sur l'editeur de page", tag: 'h1', align: 'center', hr: null,
                                       style: {
                                         'text-decoration': 'none',
                                         'font-style': 'normal',
                                         color: '#000000'
                                       }});
    }
  };
})();