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
        currentEdited: null,
        editedSource: null,
        edited: {},
        mapper: [],
        currentElement: {},
        nextPosition: 0,
        nextContainerPosition: 0,
        insideContainer: false,
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
      handleChanges(source) {
        this.showWidgets = false;
        this.showSlider = true;
        this.currentEdited = source;
      },
      updateSelected(v) {
        bbn.fn.log('update selected', v);
        /*if (this.source.items[this.currentEdited]) {
          let r = this.source.items[this.currentEdited];
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
          this.realSourceArray = this.source.items;
          this.realRowSelected = -1;
          this.editedSource = null;
        }*/
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
        const block = ev.detail.from.data;
        let elementor = this.getRef('editor');
        let guide = elementor.getRef('guide');
        let divider = elementor.getRef('divider');

        if (this.insideContainer) {
          bbn.fn.log('type', this.source.items[this.nextPosition]);
          if (this.source.items[this.nextPosition].type == 'container') {
            bbn.fn.log('drop inside real container');
            if (this.nextContainerPosition == 0) {
              this.source.items[this.nextPosition].source.items.unshift({type: block.type});
            } else {
              this.source.items[this.nextPosition].source.items.splice(this.nextContainerPosition, 0, {type: block.type});
            }
            this.cancelHelp();
            return;
          }

          let arr = this.source.items.splice(this.nextPosition, 1);
          if (this.nextContainerPosition == 0) {
            arr.unshift({type: block.type});
          }
          else if (this.nextContainerPosition == -1) {
            arr.push({type: block.type});
          }
          bbn.fn.log('array', arr);
          this.source.items.splice(this.nextPosition, 0, {
            type: 'container',
            source: {
              items: arr
            }
          });
          this.cancelHelp();
          return;
        }
        if (block.inside) {
          bbn.fn.move(this.source.items, block.index, this.nextPosition);
          this.cancelHelp();
          return;
        }
        if (this.nextPosition == 0) {
          this.source.items.unshift({type: block.type});
        }
        else if (this.nextPosition == -1) {
          this.source.items.push({type: block.type});
        }
        else {
          this.source.items.splice(this.nextPosition, 0, {type: block.type});
        }
        this.cancelHelp();
      },
      cancelHelp() {
        let elementor = this.getRef('editor');
        let guide = elementor.getRef('guide');
        let divider = elementor.getRef('divider');
        guide.style.display = "none";
        divider.style.display = "none";
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
      dragOver(e) {
        this.currentElement = e.detail.helper.getBoundingClientRect();
        let elementor = this.getRef('editor');
        let editor = elementor.$el.firstChild;
        let guide = elementor.getRef('guide');
        let divider = elementor.getRef('divider');
        let sum = 0;
        guide.style.display = "none";
        divider.style.display = "none";

        this.mapper.map((v, idx, array) => {
          sum += array[idx].height + 13;

          //check if inside
          if ((this.currentElement.y > v.y) && (this.currentElement.y < (v.y + v.height))) {
            this.insideContainer = true;
            this.nextPosition = idx;
            let rect = v.html.getBoundingClientRect();
            let mapContainer = this.mapContainer(v, idx);
            bbn.fn.log('map container', mapContainer);
            if (mapContainer && mapContainer.length >= 2) {
              mapContainer.map((v, idx, array) => {
                bbn.fn.log('element number', idx);
                if (this.currentElement.x < v.rect.width/2) {
                  if (idx > 0) {
                    bbn.fn.log('to the left');
                    this.nextContainerPosition = idx;
                  } else {
                    bbn.fn.log('at the beginning of the list');
                    this.nextContainerPosition = 0;
                  }
                }
                else if (this.currentElement.x > v.rect.width/2) {
                  bbn.fn.log('to the right');
                }
                /*if (this.currentElement.x < v.rect.width/2) {
                  if (idx > 0) {
                    bbn.fn.log('to the left of', idx);
                  } else {
                    bbn.fn.log('at the beginning of the list');
                  }
                }
                else if (this.currentElement.x > v.rect.width/2) {
                  bbn.fn.log('to the right of', idx);
                  if (array[idx + 1]) {
                    bbn.fn.log('something after');
                  } else {
                    bbn.fn.log('nothing after');
                  }
                }*/
              });
            }
            if (this.currentElement.x < rect.width/2) {
              this.nextContainerPosition = 0;
              divider.style.left = String(v.left) + 'px';
            }
            else if (this.currentElement.x > rect.width/2) {
              this.nextContainerPosition = -1;
              divider.style.left = String(rect.width/2) + 'px';
            }
            divider.style.display = "block";
            divider.style.height = String(v.height) + 'px';
            divider.style.top = String(sum - array[idx].height) + 'px';
          }

          //check if at top
          else if (this.currentElement.y < array[0].y) {
            this.insideContainer = false;
            this.nextPosition = 0;
            guide.style.display = "flex";
            guide.style.top = 0;
          }

          //check if at last
          else if (this.currentElement.y > (array.at(-1).y + array.at(-1).height)) {
            this.insideContainer = false;
            this.nextPosition = -1;
            guide.style.display = "flex";
            guide.style.top = String(sum) + 'px';
          }

          //check if between element
          else if ((this.currentElement.y < v.y) && (this.currentElement.y > (array[idx - 1].y + array[idx - 1].height))) {
            this.insideContainer = false;
            this.nextPosition = idx;
            guide.style.display = "flex";
            guide.style.top = String(sum - array[idx].height) + 'px';
          }
        });
      },
      mapContainer(src, idx) {
        if (this.source.items[idx].type == 'container') {
          let elems = src.html.querySelector('.bbn-grid').children;
          let arr = [...elems];
          let tmp_arr = [];
          arr.map((v) => {
            let detail = v.getBoundingClientRect();
            tmp_arr.push({
              rect: detail
            });
          });
          return tmp_arr;
        }
      },
      mapY() {
        let editor = this.getRef('editor').$el.firstChild.children;
        let arr = [...editor];
        let tmp_arr = [];
        arr.map((v, idx, array) => {
          let detail = v.getBoundingClientRect();
          tmp_arr.push({
            y: detail.y,
            height: detail.height,
            left: detail.left,
            width: detail.width,
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
        }, 100);
      },
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
        //Check if the currentEdited if a block or a container
        this.editedSource = null;
        if (this.source.items[v]) {
          this.currentType = this.source.items[v].type || 'text';
          if (this.currentType != 'container') {
            this.editedSource = this.source.items[this.currentEdited];
          }
        }
        /*this.$nextTick(() => {
          this.updateSelected();
        });*/
      },
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