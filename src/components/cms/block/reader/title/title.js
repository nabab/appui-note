// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, appui.mixins['appui-note-cms-reader']],
    computed: {
      tag(){
        return this.source.tag || 'h1';
      }
    }
  }
})();