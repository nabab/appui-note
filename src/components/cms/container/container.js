// Javascript Document

((bbn) => {
  return {
    /**
     * @mixin bbn.cp.mixins.basic
     */
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins.resizer],
    props: {
      source: {
        type: Object,
        required: true
      },
      index: {
        type: Number,
      },
      //the path for the index showing the images ('ex: image/')
      path: {
        type: String,
        default: ''
      },
      editable: {
        type: Boolean,
        default: false
      },
      selectable: {
        type: Boolean,
        default: false
      },
      itemSelected: {
        type: String
      },
      selected: {
        type: Boolean,
        default: false
      },
      overable: {
        type: Boolean,
        default: false
      },
      mode: {
        type: String,
        default: 'read'
      },
      dragging: {
        type: Boolean,
        default: false
      }
    },
    data(){
      return {
        over: false,
        overItem: -1,
        edit: this.mode === 'edit',
        isAdmin: true,
        editing: true,
        width: '100',
        height: '100',
        //ready is important for the component template to be defined
        ready: true,
        initialSource: null,
        currentDragging: false,
        gridLayout: {},
        editor: false
      }
    },
    computed: {
      isDragging(){
        return !!this.dragging || !!this.currentDragging;
      },
      isVertical(){
        return this.source.orientation === 'vertical';
      },
      gridStyle(){
        let style = {};
        let elements = this.source.layout?.length ? this.source.layout.split(' ') : [];
        let arr = [];
        if (this.overable && !!elements) {
          bbn.fn.each(elements, (e, i) => {
            arr.splice(i * 2, 0, 'max-content', e);
          });
          arr.push('max-content');
        }
        else {
          arr = elements;
        }

        let s = arr.join(' ');
        if (this.isVertical) {
          style.gridTemplateRows = s;
          style.height = '100%';
          style.maxHeight = '100%';
        }
        else {
          style.gridTemplateColumns = s;
          style.width = '100%';
          style.maxWidth = '100%';
        }
        if (!!this.source.align) {
          style.justifyContent = this.source.align;
        }
        if (!!this.source.valign) {
          style.alignItems = this.source.valign;
          style.alignContent = this.source.valign;
        }

        return style;
      },
      isSelected() {
        return this.selected === true;
      },
      currentComponent(){
        return this.getComponentName(this.type);
      },
      changed(){
        return this.ready && !bbn.fn.isSame(this.initialSource, this.source);
      },
      type(){
        return this.source.type || 'text'
      },
      parent(){
        return this.ready ? this.closest('bbn-container').getComponent() : null;
      }
    },
    methods: {
      randomString: bbn.fn.randomString,
      getDraggableData(index, src, type){
        if (this.overable) {
          return {
            data: {
              type: type,
              index: index,
              source: src,
              parentUid: this.$cid,
              parentSource: this.source.items
            },
            mode: 'clone'
          };
        }

        return false;
      },
      addBlock() {
        bbn.fn.log('ADDBLOCK')
        if (this.source.items === undefined) {
          this.$set(this.source, 'items', []);
        }
        this.source.items.push({
          _elementor: this.closest('appui-note-cms-editor').getElementorDefaultObj(),
          type: 'text',
          content: ''
        });
      },
      removeBlock(idx) {
        this.source.items.splice(idx, 1);
      },
      selectBlock(key, src, items, ev) {
        if (this.overable) {
          if (ev) {
            ev.stopImmediatePropagation();
          }
          this.$emit('selectblock', key, src, items);
        }
      },
      configInit(config) {
        this.$emit('config-init', config);
      },
      onDragStart(ev){
        this.currentDragging = true;
        this.$emit('dragstart', ev);
      },
      onDragEnd(ev){
        this.currentDragging = false;
        this.$emit('dragend', ev);
      },
      onDrop(ev){
        this.onDragEnd();
        let fromData = ev.detail.from.data;
        if (!!fromData.type && (fromData.source !== undefined)) {
          let newSource = bbn.fn.clone(fromData.source);
          let toData = ev.detail.to.data;
          let oldIndex = null;
          let newIndex = toData.index;
          let deleted = false;
          switch (fromData.type) {
            case 'cmsDropper':
              bbn.fn.iterate(fromData.cfg || {}, (v, k) => newSource[k] = v);
              newSource._elementor = this.editor.getElementorDefaultObj();
              break;
            case 'cmsContainerBlock':
            case 'cmsBlock':
            case 'cmsContainer':
              oldIndex = fromData.index;
              if ((fromData.parentSource !== undefined)
                && (!!toData.replace
                  || (fromData.parentUid !== this.$cid))
              ) {
                deleted = fromData.parentSource.splice(oldIndex, 1);
              }
              break;
            default:
              return;
          }
          if (!!toData.replace) {
            let ns = bbn.fn.extend(
              true,
              {
                type: 'container',
                _elementor: this.editor.getElementorDefaultObj()
              },
              bbn.fn.getRow(appui.cms.blocks, 'code', 'container').configuration
            );
            if (ns.items === undefined) {
              ns.items = [];
            }
            ns.items.push(toData.source, newSource);
            newSource = ns;
          }
          if (bbn.fn.isNull(oldIndex)
            || !!deleted
          ) {
            if (!!deleted
              && (fromData.parentUid === this.$cid)
              && (oldIndex < newIndex)
            ) {
              newIndex--;
            }
            if (this.source.items === undefined) {
              this.$set(this.source, 'items', []);
            }
            this.source.items.splice(newIndex, toData.replace ? 1 : 0, newSource);
          }
          else if ((fromData.parentUid === this.$cid)
            && ((newIndex < oldIndex)
            || (newIndex > (oldIndex + 1)))
          ){
            if (newIndex > oldIndex) {
              newIndex--;
            }
            bbn.fn.move(this.source.items, oldIndex, newIndex);
          }
        }
      },
      getWidgetName(type){
        let blocks = (appui.cms?.blocks || []).concat(appui.cms?.pblocks || []);
        return bbn.fn.getField(blocks, 'text', 'code', type) || bbn._('Unknown');
      },
      setGridLayout(){
        let arr = [];
        if (this.source.layout?.length) {
          arr = this.source.layout.split(' ');
        }
        if (!!this.source.items?.length
          && (arr.length < this.source.items.length)
        ) {
          arr = arr.concat(Array.from({length: this.source.items.length - arr.length}, a => arr.length ? 'auto' : '1fr'));
        }
        if (!!this.source.items?.length
          && (arr.length > this.source.items.length)
        ) {
          arr.splice(this.source.items.length, arr.length);
        }
        this.$set(this, 'gridLayout', Object.assign({}, arr));
        return this.gridLayout;
      },
    },
    created(){
      this.setGridLayout();
    },
    mounted() {
      if (this.source.orientation === undefined) {
        this.$set(this.source, 'orientation', 'horizontal');
      }
      this.$set(this, 'editor', this.closest('appui-note-cms-editor'));
    },
    watch: {
      gridLayout: {
        deep: true,
        handler(newVal){
          this.$set(this.source, 'layout', Object.values(newVal).join(' '));
      }
    },
      'source.items'(){
        this.setGridLayout();
      }
    }
  };
})(bbn);
