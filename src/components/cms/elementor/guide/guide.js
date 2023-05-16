(() => {
  return {
    props: {
      visible: {
        type: Boolean,
        default: false
      },
      force: {
        type: Boolean,
        default: false
      },
      vertical: {
        type: Boolean,
        default: false
      }
    },
    data(){
      return {
        isOver: false
      }
    },
    computed: {
      isVisible(){
        return this.visible && (this.force || this.isOver);
      }
    },
    methods: {
      onDrop(ev){
        ev.stopImmediatePropagation();
        ev.preventDefault();
        bbn.fn.log('eee', ev)
        this.$emit('drop', ev);
      }
    }
  }
})();