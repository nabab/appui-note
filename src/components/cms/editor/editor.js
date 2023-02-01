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
      },
      pblocks: {
        type: Array
      }
    },
    data() {
      return {
        data: null,
        oData: JSON.stringify(this.source),
        oConfig: null,
        ready: false,
        root: appui.plugins['appui-note'] + '/',
        showFloater: false,
        showSlider: false,
        showWidgets: false,
        currentEdited: null,
        currentEditedIndex: -1,
        currentEditedIndexInContainer: null,
        editedSource: null,
        map: [],
        currentPosition: {},
        nextPosition: 0,
        nextContainerPosition: 0,
        insideContainer: false,
        dataElementor: {},
        containerPosition: {},
        preview: false,
        currentContainer: null,
        originalConfig: null,
        isReady: true
      };
    },
    computed: {
      allBlocks() {
        const arr = [];
        bbn.fn.each(this.pblocks, a => {
          const block = bbn.fn.clone(bbn.fn.getRow(this.blocks, {id: a.id_alias}));
          if (!block) {
            bbn.fn.error(bbn._("The block doesn't exist"));
          }
          block.text = a.text;
          block.cfg = a.configuration;
          block.personalized = true;
          block.id = a.id;
          arr.push(block);
        });
        arr.push(...this.blocks);
        return arr;
      },
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
      isConfigChanged() {
        bbn.fn.log("config changed", this.currentEdited, this.originalConfig);
        let isChanged = false;
        if (this.originalConfig) {
          bbn.fn.iterate(this.currentEdited, (value, prop) => {
            if ((!bbn.fn.isSame(this.originalConfig[prop], value)) && this.originalConfig[prop] !== undefined) {
              isChanged = true;
              return false;
            }
          });
        }
        return isChanged;
      }
    },
    methods: {
      unselectElements() {
        this.currentEdited = null;
        this.currentEditedIndex = -1;
        this.currentEditedIndexInContainer = null;
        this.showSlider = false;
      },
      setOriginalConfig(config) {
        this.originalConfig = config;
      },
      saveConfig() {
       	this.getPopup({
          component: this.$options.components.configForm,
          source: this.currentEdited,
          title: false
        });
      },
      getBlockTitle(code) {
        return bbn.fn.getField(this.blocks, 'text', {code});
      },
      /**
       * Removes the 'product' property from the object to be submitted
       * @todo ask Loredana
       */
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
      /**
       * Convert the source in a JSON string
       */
      onSave() {
        this.oData = JSON.stringify(this.source);
        appui.success(bbn._("Saved"));
      },
      /**
       * Clear the cache of the page via the page configuration.
       */
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
      /**
       * Save the settings of the page and close the slider.
       */
      saveSettings() {
        this.$refs.form.submit();
        this.showFloater = false;
      },
      /**
       * When changes are made to a block or a block inside a container, the currentEdited data receive
       * the source of the block.
       * @param {Object} source the source object of the current selected block
       */
      handleSelected(index, source, indexInContainer = null) {
        this.showWidgets = false;
        this.currentEdited = null;
        setTimeout(() => {
          this.currentEditedIndex = index;
          this.currentEdited = source;
          if (indexInContainer !== null) {
            this.currentEditedIndexInContainer = indexInContainer;
          }
          this.showSlider = true;
        }, 250);
      },
      /**
       * Delete the current selected block
       */
      deleteCurrentSelected() {
        this.confirm(bbn._("Are you sure you want to delete this block and its content?"), () => {
          let idx = this.currentEditedIndex;
          let idxInContainer = this.currentEditedIndexInContainer;
          if (this.currentEditedIndexInContainer) {
            this.source.items[idx].source.items.splice(idxInContainer, 1);
            this.mapY();
            return;
          }
          this.source.items.splice(idx, 1);
          this.currentEditedIndex = -1;
          this.showSlider = false;
          this.mapY();
        });
      },
      /**
       * Function triggered after the release of a block into the droppable zone.
       * @param {Event} ev the event of the dropped block
       * @return void
       */
      onDrop(ev) {
        const block = bbn.fn.clone(ev.detail.from.data.source);
        this.currentBlockConfig = ev.detail.from.data.cfg || {};
        bbn.fn.log("block config", this.currentBlockConfig);
        let elementor = this.getRef('editor');
        let guide = elementor.getRef('guide');
        let divider = elementor.getRef('divider');
        let movedItem = false;

        // Check if the moved block comes from inside the elementor component
        if (this.source.items[this.dataElementor.dataIndex || null]) {
          // if a container already exists dataContainerIndex will exist
          if (this.dataElementor.dataContainerIndex) {
            movedItem = this.source.items[this.dataElementor.dataIndex].source.items.splice(this.dataElementor.dataContainerIndex, 1);
            //transform into normal block
            if (this.source.items[this.dataElementor.dataIndex].source.items.length === 1) {
              let last_block = this.source.items[this.dataElementor.dataIndex].source.items[0];
              this.source.items.splice(this.dataElementor.dataIndex, 1, last_block);
            }
          }
          else {
            movedItem = this.source.items.splice(this.dataElementor.dataIndex, 1);
          }
          this.cancelHelp();
          this.dataElementor = {};
        }
        // block is dropped inside another block and create a container
        if (this.insideContainer) {
          // avoid creating container inside container
          if (this.source.items[this.nextPosition].type == 'container') {
            bbn.fn.log('avoid creation multiple containers', block, ev.detail.from);
            if (this.nextContainerPosition == 0) {
              this.source.items[this.nextPosition].source.items.unshift(block);
            } else {
              this.source.items[this.nextPosition].source.items.splice(this.nextContainerPosition, 0, block);
            }
            this.cancelHelp();
            return;
          }

          let arr = this.source.items.splice(this.nextPosition, 1);
          if (this.nextContainerPosition == 0) {
            arr.unshift(block);
          }
          else if (this.nextContainerPosition == -1) {
            arr.push(block);
          }
          //bbn.fn.log('array', arr);
          this.source.items.splice(this.nextPosition, 0, {
            type: 'container',
            source: {
              items: arr
            }
          });
          this.cancelHelp();
          return;
        }
        // Place the block at the correct index position
        bbn.fn.log('place block at correct index');
        if (this.nextPosition == 0) {
          this.source.items.unshift(block);
        }
        else if (this.nextPosition == -1) {
          this.source.items.push(block);
        }
        else {
          this.source.items.splice(this.nextPosition, 0, block);
        }
        this.cancelHelp();
      },
      /**
       * Remove the guide and the divider element by applying the style 'display: none'.
       */
      cancelHelp() {
        let elementor = this.getRef('editor');
        let guide = elementor.getRef('guide');
        let divider = elementor.getRef('divider');
        guide.style.display = "none";
        divider.style.display = "none";
      },
      /**
       * Move the selected block with the arrows in the configuration panel.
       * @param {String} dir the given direction
       */
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
      /**
       * Function triggered when a drag & drop block is hovering the droppable zone.
       * @param {Event} e the event triggered
       */
      dragOver(e) {
        // Check if map is empty or not
        if (this.map.length == 0) {
          return false;
        }
        this.currentPosition = e.detail.helper.getBoundingClientRect();
        let elementor = this.getRef('editor');
        let editor = elementor.$el.firstChild;
        let guide = elementor.getRef('guide');
        let divider = elementor.getRef('divider');
        let sum = 0;
        guide.style.display = 'none';
        divider.style.display = 'none';

        //check if the current position is at top
        if (this.currentPosition.y < this.map[0].y) {
          bbn.fn.log('top of the map');
          this.insideContainer = false;
          this.nextPosition = 0;
          guide.style.display = "flex";
          guide.style.top = 0;
        }
        //check if the current position is at bottom
        else if (this.currentPosition.y > (this.map.at(-1).y + this.map.at(-1).height)) {
          bbn.fn.log('bottom of the map');
          this.insideContainer = false;
          this.nextPosition = -1;
          guide.style.display = "flex";
          guide.style.position = 'absolute';
          this.containerPosition = this.getRef('editor').$el.getBoundingClientRect();
          guide.style.top = (this.map.at(-1).y + this.map.at(-1).height - this.containerPosition.y) + 'px';
        }
        //check if the current position is inside an element
        else {
          bbn.fn.each(this.map, (v, idx) => {
            sum += v.height + 13;
            //check if current position is inside a block
            if ((this.currentPosition.y > v.y) && (this.currentPosition.y < (v.y + v.height))) {
              bbn.fn.log('inside a block');
              this.insideContainer = true;
              this.nextPosition = this.map.indexOf(v);
              let rect = v.html.getBoundingClientRect();
              let mapContainer = this.mapContainer(v, this.map.indexOf(v));
              //Check if the block is a container and do a mapper inside of it
              if (mapContainer && mapContainer.length >= 2) {
                bbn.fn.log('move inside container');
                mapContainer.map((v, idx, array) => {
                  if (this.currentPosition.x < v.rect.width/2) {
                    if (idx > 0) {
                      this.nextContainerPosition = idx;
                    } else {
                      this.nextContainerPosition = 0;
                    }
                    return false;
                  }
                  else if (this.currentPosition.x > v.rect.width/2) {
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
              if (this.currentPosition.x < rect.width/2) {
                this.nextContainerPosition = 0;
                divider.style.left = v.left + 'px';
              }
              else if (this.currentPosition.x > rect.width/2) {
                this.nextContainerPosition = -1;
                divider.style.left = rect.width/2 + 'px';
              }
              divider.style.display = "block";
              divider.style.height = v.height + 'px';
              divider.style.top = (sum - v.height) + 'px';
              return false;
            }
            else if (this.currentPosition.y > (v.y + v.height) && this.currentPosition.y < (v.y + bbn.fn.outerHeight(v.html.parentElement))) {
              this.insideContainer = false;
              this.nextPosition = idx + 1;
              guide.style.display = 'flex';
              guide.style.position = 'absolute';
              guide.style.top = (sum) + 'px';
              const css = getComputedStyle(guide);
              return false;
            }
          });
        }
      },
      /**
       * Function to map inside a container block.
       * @param {Object} src the source of the container's items
       * @param {number} idx the index of the container in the global source
       */
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
      /**
       * Function to map the elements in elementor editor in an array.
       */
      mapY() {
        let editor = this.getRef('editor');
        let tmp_arr = [];
        this.source.items.map((v, idx) => {
          let ele = editor.getRef('block' + idx);
          let detail = ele.$el.getBoundingClientRect();
          tmp_arr.push({
            y: detail.y,
            height: detail.height,
            left: detail.left,
            width: detail.width,
            index: idx,
            html: ele.$el,
          });
          this.map = tmp_arr.slice();
        });
      },
      /**
       * Function triggered when dragging an element
       */
      dragStart(data) {
        this.dataElementor = data;
      },
      /**
       * Do a mapping when scrolling the delementor component
       */
      scrollElementor() {
        setTimeout(() => {
          this.mapY();
        }, 500);
      }
    },
    watch: {
      'source.items'() {
        setTimeout(() => {
          this.mapY();
        }, 500);
      },
      'editedSource.type'(v, ov) {
        //bbn.fn.log(v, ov, '???');
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
        this.isReady = false;
        setTimeout(() => {
          this.isReady = true;
        }, 100);
      },
    },
    mounted() {
      //Set a default title block when creating a new page.
      this.data = this.closest('bbn-router').closest('bbn-container').source;
      setTimeout(() => {
        this.mapY();
      }, 500);
    },
    components: {
      configForm: {
        template:`
<bbn-form :action="root + 'cms/actions/config/insert'"
					:source="formData">
	<div class="bbn-grid-fields bbn-lg bbn-lpadding">
  	<div v-text="_('Name of your block')"/>
    <bbn-input v-model="formData.name"
    					 :required="true"/>
  </div>
</bbn-form>
        `,
        props: {
          source: {
            type: Object
          }
        },
        data() {
          return {
            root: appui.plugins['appui-note'] + '/',
            formData: {
              name: '',
              config: this.source
            }
          };
        }
      }
    }
  };
})();