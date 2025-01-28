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
      },
      currentStyle(){
        return {
          visibility: this.isVisible ? 'visible' : 'hidden'
        }
      }
    },
    methods: {
      onDrop(ev){
        ev.stopImmediatePropagation();
        ev.preventDefault();
        this.$emit('drop', ev);
      }
    }
  }
})();