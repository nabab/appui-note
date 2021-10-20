// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data(){
      return {
        units: [{
          text: '%',
          value: '%'
        }, {
          text: 'px',
          value: 'px'
        }, {
          text: 'em',
          value: 'em'
        }],
        currentSize: this.source.size,
        currentUnit: 'em'
      }
    },
    watch: {
      currentSize(val){
        this.source.size = this.currentSize;
      },
      currentUnit(val){
        this.source.size = this.currentSize + this.currentUnit;
      }
    }
  }
})();