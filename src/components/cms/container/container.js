// Javascript Document

((bbn) => {
  return {
    /**
     * @mixin bbn.vue.basicComponent
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
        type: Number,
        default: -1
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
        currentItemSelected: this.itemSelected
      }
    },
    computed: {
      gridStyle(){
        let style = `gridTemplateColumns: repeat( ` + this.source.items.length + `, 1fr)`;
        if ( bbn.fn.isMobile() ){
          style = `gridTemplateRows: repeat( ` + this.source.items.length + `, auto)`;
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
      clickBlock(i) {
        this.$emit('click', i);
      }
    },
    watch: {
      itemsSelected(v) {
        this.currentItemSelected = v;
      },
      currentItemSelected(v) {
        if (v > -1) {
          /*this.$emit('select', {
            currentItemIndex: this.currentItemSelected,
            cfg: this.source
          });*/
        }
      }
    }
  };
})(bbn);