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
      gridStyle(){
        let style = {};
        let elements = this.source.items.length;
        if (this.overable && !!elements) {
          elements = elements * 2 + 1;
        }

        let s = '';
        for (let i = 1; i <= elements; i++) {
          s += (i % 2) && this.overable ? 'max-content ' : '1fr ';
        }

        if (this.isMobile) {
          style.gridTemplateRows = s;
        }
        else {
          style.gridTemplateColumns = s;
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
      addBlock() {
        this.source.items.push({
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
      }
    },
    mounted() {
      bbn.fn.log('prop container', this.source);
    }
  };
})(bbn);