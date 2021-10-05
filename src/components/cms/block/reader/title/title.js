// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-reader']],
    computed: {
      tag(){
        return this.source.tag || 'h1';
      }
    }
  }
})();