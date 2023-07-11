// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
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
        type: Array,
        default() {
          return [];
        }
      }
    },
    data() {
      return {
        isDev: appui.app.user.isDev,
        data: null,
        oData: JSON.stringify(this.source),
        oConfig: null,
        ready: false,
        root: appui.plugins['appui-note'] + '/',
        showWidgetSettings: false,
        showWidgets: false,
        showPageSettings: false,
        sliderMaximized: false,
        currentEditing: null,
        currentEditingKey: null,
        currentEditingParent: null,
        editedSource: null,
        map: [],
        currentPosition: {},
        nextPosition: 0,
        nextContainerPosition: -1,
        insideContainer: false,
        dataElementor: {},
        containerPosition: {},
        preview: false,
        showJSON: false,
        currentContainer: null,
        originalConfig: null,
        isReady: false,
        currentBlockConfig: null,
        personalizedBlocks: this.pblocks.slice(),
        classicBlocks: this.blocks || [],
        isDragging: false
      };
    },
    computed: {
      currentEditingTitle() {
        if (this.currentEditing) {
          if (this.currentEditing.special) {
            let txt = bbn.fn.getField(this.allBlocks, 'text', {special: this.currentEditing.special});
            if (!txt) {
              this.$delete(this.currentEditing, 'special');
            } else {
              return txt;
            }
          }
          return bbn.fn.getField(this.allBlocks, 'text', {special: null, code: this.currentEditing.type});
        }
      },
      allBlocks() {
        const arr = [];
        bbn.fn.each(this.personalizedBlocks, a => {
          const block = bbn.fn.clone(bbn.fn.getRow(this.classicBlocks, {id: a.id_alias}));
          if (!block) {
            bbn.fn.error(bbn._("The block doesn't exist"));
          }
          block.text = a.text;
          block.cfg = a.configuration;
          block.special = a.id;
          block.id_alias = block.id;
          block.id = a.id;
          arr.push(block);
        });
        //arr.push(...this.blocks);
        arr.push(...this.classicBlocks.map(a => {
          const it = bbn.fn.clone(a);
          it.special = null;
          return it;
        }));
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
        let isChanged = false;
        if (this.originalConfig) {
          let ignoredFields = [];
          let block = this.getRef('blockEditor');
          if (block) {
            let edi = block.getRef('component');
            if (edi && edi.ignoredFields) {
              ignoredFields = edi.ignoredFields;
            }
          }
          bbn.fn.iterate(this.currentEditing, (value, prop) => {
            if (!ignoredFields.includes(prop) && !bbn.fn.isSame(this.originalConfig[prop], value)) {
              isChanged = true;
              return false;
            }
          });
        }
        return isChanged;
      },
      currentEditingParentItems(){
        if (!!this.currentEditingParent) {
          return this.currentEditingParent.source.items;
        }
        return null;
      },
      currentEditingIndex(){
        if (!!this.currentEditingKey && !!this.currentEditingParentItems) {
          return bbn.fn.search(this.currentEditingParentItems, '_elementor.key', this.currentEditingKey);
        }
        return -1;
      },
      showSlider(){
        return !!this.showPageSettings || !!this.showWidgetSettings || !!this.showWidgets;
      }
    },
    methods: {
      randomString: bbn.fn.randomString,
      scrollToSelected() {
        
      },
      unselectElements() {
        this.currentEditing = null;
        this.currentEditingKey = null;
        this.currentEditingParent = null;
        this.closeSlider();
      },
      setOriginalConfig(config) {
        this.originalConfig = config;
      },
      saveConfig() {
        this.getPopup({
          component: this.$options.components.configForm,
          source: this.currentEditing,
          title: false
        });
      },
      getBlockTitle(id) {
        return bbn.fn.getField(this.allBlocks, 'text', {id});
      },
      save(){
        let src = bbn.fn.clone(this.source);
        this.clearItem(src);
        return this.post(this.action, src, d => {
          if (d.success) {
            this.oData = JSON.stringify(this.source);
            appui.success(bbn._('Saved'));
          }
          else {
            appui.error();
          }
        });
      },
      clearItem(item){
        if (!!item.items) {
          bbn.fn.each(item.items, this.clearItem);
        }
        else if ((item.type === 'product') && (item.id_product !== undefined)) {
          item.content = item.id_product;
          delete item.id_product;
        }
        if (item._elementor !== undefined) {
          delete item._elementor;
        }
        return item;
      },
      normalizeItems(items){
        bbn.fn.each(items, (v, i) => {
          if ((v.type === 'container') && !!v.items) {
            this.normalizeItems(v.items);
          }
          this.$set(items[i], '_elementor', this.getElementorDefaultObj(i));
        });
        return items;
      },
      getElementorDefaultObj(index){
        return {
          key: bbn.fn.randomString(32, 32)
        }
      },
      /**
       * Clear the cache of the page via the page configuration.
       */
      clearCache() {
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
      toggleWidgets(){
        this.showWidgets = !this.showWidgets;
      },
      togglePageSettings(){
        this.showPageSettings = !this.showPageSettings;
      },
      closeSlider(){
        this.showWidgets = false;
        this.showWidgetSettings = false;
        this.showPageSettings = false;
      },
      /**
       * Save the settings of the page and close the popup.
       */
      saveSettings() {
        this.save().then(d => {
          if (d.data && d.data.success) {
            let popup = this.getPopup();
            if (popup) {
              popup.close(popup.items.length - 1, true);
            }
          }
        });
      },
      /**
       * When changes are made to a block or a block inside a container, the currentEditing data receive
       * the source of the block.
       * @param {Object} source the source object of the current selected block
       */
      handleSelected(key, source, parent) {
        bbn.fn.log('select', key, source)
        if (this.currentEditingKey !== key) {
          this.currentEditingKey = key;
          this.currentEditing = source;
          this.currentEditingParent = parent;
          this.showWidgetSettings = true;
        }
      },
      /**
       * Delete the current selected block
       */
      deleteCurrentSelected() {
        this.confirm(bbn._("Are you sure you want to delete this block and its content?"), () => {
          if (this.currentEditingKey && !!this.currentEditingParentItems?.length) {
            let idx = bbn.fn.search(this.currentEditingParentItems, '_elementor.key', this.currentEditingKey);
            if (idx > -1) {
              this.currentEditingParentItems.splice(idx, 1);
            }
            this.currentEditingKey = null;
            this.currentEditing = null;
            this.currentEditingParent = null;
            this.showWidgetSettings = false;
          }
          else {
            appui.error();
          }
        });
      },
      /**
       * Function triggered after the release of a block into the droppable zone.
       * @param {Event} ev the event of the dropped block
       * @return void
       */
      onDrop(ev) {
        bbn.fn.log('DROP', ev, bbn.fn.clone(ev.detail.from.data));
        const block = bbn.fn.clone(ev.detail.from.data.source);
        this.currentBlockConfig = ev.detail.from.data.cfg || {};
        bbn.fn.iterate(this.currentBlockConfig, (a, n) => block[n] = a);
        let elementor = this.getRef('editor');
        let guide = elementor.getRef('guide');
        let divider = elementor.getRef('divider');
        let movedItem = false;
        let found = this.allBlocks.find(el => el.id === block.special);

        if (!found) {
        }

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
          this.source.items.splice(this.nextPosition, 0, {
            type: 'container',
            source: {
              items: arr
            }
          });
          this.cancelHelp();
          return;
        }
        block._elementor = this.getElementorDefaultObj(0);
        // Place the block at the correct index position
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
        //guide.style.display = "none";
        divider.style.display = "none";
      },
      /**
       * Move the selected block with the arrows in the configuration panel.
       * @param {String} dir the given direction
       */
      move(dir) {
        if (!!this.currentEditingKey && !!this.currentEditingParentItems) {
          let currentIdx = bbn.fn.search(this.currentEditingParentItems, '_elementor.key', this.currentEditingKey);
          if (currentIdx > -1) {
            let newIdx;
            switch (dir) {
              case 'start':
                newIdx = 0;
                break;
              case 'before':
                if (currentIdx > 0) {
                  newIdx = currentIdx - 1;
                }
                break;
              case 'after':
                if (currentIdx < (this.currentEditingParentItems.length - 1)) {
                  newIdx = currentIdx + 1;
                }
                break;
              case 'end':
                newIdx = this.currentEditingParentItems.length - 1;
                break;
            }
            if (this.currentEditingParentItems[newIdx]) {
              bbn.fn.move(this.currentEditingParentItems, currentIdx, newIdx);
            }
          }
        }
      },
      /**
       * Function triggered when a drag & drop block is hovering the droppable zone.
       * @param {Event} e the event triggered
       */
      dragOver(e) {
        bbn.fn.log('draOver', e)
        return;
        let elementor = this.getRef('editor');
        let guide = elementor.getRef('guide');
        // Check if map is empty or not
        if (!this.map.length) {
          guide.style.display = 'flex';
          guide.style.top = 0;
          return false;
        }

        this.currentPosition = e.detail.helper.getBoundingClientRect();
        let editor = elementor.$el.firstChild;
        let divider = elementor.getRef('divider');
        let sum = 0;
        guide.style.display = 'none';
        divider.style.display = 'none';

        //check if the current position is at top
        if (this.currentPosition.y < this.map[0].y) {
          this.insideContainer = false;
          this.nextPosition = 0;
          guide.style.display = "flex";
          guide.style.top = 0;
        }
        //check if the current position is at bottom
        else if (this.currentPosition.y > (this.map.at(-1).y + this.map.at(-1).height)) {
          this.insideContainer = false;
          this.nextPosition = -1;
          guide.style.display = "flex";
          guide.style.position = 'absolute';
          this.containerPosition = this.getRef('editor').$el.getBoundingClientRect();
          guide.style.top = (this.map.at(-1).y + this.map.at(-1).height - this.containerPosition.y) + 'px';
        }
        //check if the current position is inside an element
        else {
          bbn.fn.each(this.map, (block, idx) => {
            sum += block.height + 13;
            //check if current position is inside a block
            if ((this.currentPosition.y > block.y)
              && (this.currentPosition.y < (block.y + block.height))
            ) {
              this.insideContainer = true;
              this.nextPosition = this.map.indexOf(block);
              let rect = block.html.getBoundingClientRect();
              let mapContainer = this.mapContainer(block, this.map.indexOf(block));
              if (mapContainer && mapContainer.length >= 2) {
                bbn.fn.each(mapContainer, (cont, idx) => {
                  let block = cont.rect;
                  let setDividerStyle = false;
                  // If we are at the beginning of the container
                  if (this.currentPosition.x < (mapContainer[0].rect.x + mapContainer[0].rect.width / 4)) {
                    setDividerStyle = true;
                    this.nextContainerPosition = 0;
                    divider.style.width = '3px';
                    divider.style.left = mapContainer[0].rect.left + 'px';
                  }
                  // If we are at the end of the container
                  if (this.currentPosition.x > (mapContainer.at(-1).rect.x + (3*mapContainer.at(-1).rect.width / 4))) {
                    setDividerStyle = true;
                    this.nextContainerPosition = 0;
                    divider.style.width = '3px';
                    divider.style.left = mapContainer.at(-1).rect.x + mapContainer.at(-1).rect.width - 3 + 'px';
                  }
                  // If we are between two blocks in a container
                  if (this.currentPosition.x > block.x + block.width && this.currentPosition.x < mapContainer[idx + 1].rect.x) {
                    setDividerStyle = true;
                    this.nextContainerPosition = idx + 1;
                    divider.style.width = block.width + 'px';
                    divider.style.left = (block.right - block.width/2)  + 'px';
                  }
                  if (setDividerStyle) {
                    divider.style.display = "block";
                    divider.style.height = block.height - 4 + 'px';
                    divider.style.top = (sum - block.height) + 'px';
                  }
                });
              } else {
                if (this.currentPosition.x < rect.width/2) {
                  this.nextContainerPosition = 0;
                  divider.style.left = block.left + 'px';
                }
                else if (this.currentPosition.x > rect.width/2) {
                  this.nextContainerPosition = -1;
                  divider.style.left = Math.round(rect.width/2) + 10 + 'px';
                }
                divider.style.display = "block";
                divider.style.height = block.height - 4 + 'px';
                divider.style.width = (block.width / 2) + 'px';
                divider.style.top = (sum - block.height) + 'px';
                //return false;
              }
            }
            else if (this.currentPosition.y > (block.y + block.height) && this.currentPosition.y < (block.y + bbn.fn.outerHeight(block.html.parentElement))) {
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
        if (!editor || this.showJSON || this.preview) {
          return;
        }

        let tmp_arr = [];
        this.source.items.map((v, idx) => {
          let ele = editor.getRef('block' + idx.toString());
          if (ele?.$el && ele.$el.getBoundingClientRect) {
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
          }
					else {
            bbn.fn.log('false mapper', ele.$el, idx);
          }
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
    beforeMount(){
      if (bbn.fn.isArray(this.source?.items)) {
        this.normalizeItems(this.source.items);
      }
    },
    mounted(){
      const data = this.closest('bbn-router').closest('bbn-container').source;
      if (!this.classicBlocks.length && !this.personalizedBlocks.length) {
        if (!appui.cms?.blocks) {
          bbn.fn.post(this.root + 'cms/data/blocks', d => {
            if (d.blocks) {
              if (!appui.cms) {
                appui.cms = bbn.fn.createObject();
              }
              appui.cms.blocks = d.blocks;
              appui.cms.pblocks = d.pblocks || [];
            }
            this.classicBlocks.push(...appui.cms.blocks);
            this.personalizedBlocks.push(...appui.cms.pblocks);
            this.data = data;
          });
        }
        else {
          this.classicBlocks.push(...appui.cms.blocks);
          this.personalizedBlocks.push(...appui.cms.pblocks);
          this.data = data;
        }
      }
      else {
        this.data = data;
      }
      if (!!this.source.items && !this.source.items.length) {
        this.showWidgets = true;
      }
    },
    watch: {
      'source.items'() {
        setTimeout(() => {
          this.mapY();
        }, 500);
      },
      'editedSource.type'(v, ov) {
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
      currentEditing(v, ov) {
        if (!ov || !v || (v.type !== ov.type)) {
          this.isReady = false;
          setTimeout(() => {
            this.isReady = true;
          }, 100);
        }
        /*this.$nextTick(() => {
          this.updateSelected();
        });*/
      },
      ready() {
        this.mapY();
      },
      showWidgets(newVal){
        if (!!newVal) {
          this.showWidgetSettings = false;
          this.showPageSettings = false;
        }
      },
      showWidgetSettings(newVal){
        if (!!newVal) {
          this.showWidgets = false;
          this.showPageSettings = false;
        }
        else {
          this.currentEditing = null;
          this.currentEditingKey = null;
          this.currentEditingParent = null;
        }
      },
      showPageSettings(newVal){
        if (!!newVal) {
          this.showWidgetSettings = false;
          this.showWidgets = false;
        }
      }
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
