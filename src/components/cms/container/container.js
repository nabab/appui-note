// Javascript Document

((bbn) => {
  return {
    /**
     * @mixin bbn.vue.basicComponent
     * @mixin bbn.vue.resizerComponent
     */
    mixins: [bbn.vue.basicComponent, bbn.vue.resizerComponent],
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
        currentDragging: false
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
        let elements = this.source.items.length;
        if (this.overable && !!elements) {
          elements = elements * 2 + 1;
        }

        let s = '';
        for (let i = 1; i <= elements; i++) {
          s += (i % 2) && this.overable ? 'max-content ' : 'auto ';
        }

        if (this.isVertical) {
          style.gridTemplateRows = s;
          style.height = '100%';
        }
        else {
          style.gridTemplateColumns = s;
          style.width = '100%';
        }
        if (!!this.source.align) {
          style.justifyContent = this.source.align;
        }
        if (!!this.source.valign) {
          style.alignItems = this.source.valign;
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
      getDraggableData(index, src, type){
        if (this.overable) {
          return {
            data: {
              type: type,
              index: index,
              source: src,
              parentUid: this._uid,
              parentSource: this.source.items
            },
            mode: 'clone'
          };
        }

        return false;
      },
      addBlock() {
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
      selectBlock(key, src, ev) {
        if (this.overable) {
          if (ev) {
            ev.stopImmediatePropagation();
          }
          this.$emit('selectblock', key, src);
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
        bbn.fn.log('aaaaaa', ev)
        this.onDragEnd();
        let fromData = ev.detail.from.data;
        if (!!fromData.type && (fromData.source !== undefined)) {
          let newSource = bbn.fn.clone(fromData.source);
          let toData = ev.detail.to.data;
          let oldIndex = null;
          let newIndex = toData.index;
          switch (fromData.type) {
            case 'cmsDropper':
              bbn.fn.iterate(fromData.cfg || {}, (v, k) => newSource[k] = v);
              newSource._elementor = {
                key: bbn.fn.randomString(32, 32)
              }
              break;
            case 'cmsContainerBlock':
            case 'cmsBlock':
            case 'cmsContainer':
              oldIndex = fromData.index;
              if ((fromData.parentSource !== undefined)
                && ((fromData.parentUid !== this._uid)
                  || ((newIndex < oldIndex)
                    || (newIndex > (oldIndex + 1))))
              ) {
                fromData.parentSource.splice(oldIndex, 1);
              }
              break;
          }
          if (bbn.fn.isNull(oldIndex)
            || ((fromData.parentSource !== undefined)
              && ((fromData.parentUid !== this._uid)
                || ((newIndex < oldIndex)
                  || (newIndex > (oldIndex + 1)))))
          ) {
            if (this.source.items === undefined) {
              this.$set(this.source, 'items', []);
            }
            this.source.items.splice(newIndex, 0, newSource);
          }
        }
      },
    },
    mounted() {
      if (this.source.orientation === undefined) {
        this.$set(this.source, 'orientation', 'horizontal');
      }
    }
  };
})(bbn);