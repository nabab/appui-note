// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-reader']],
    computed: {
      alignClass(){
        let st = 'bbn-c';
        if ( this.source.align === 'left' ){
          st = 'bbn-l'
        }
        if ( this.source.align === 'right' ){
          st = 'bbn-r'
        }
        return st;
      },
    }
  }
})();