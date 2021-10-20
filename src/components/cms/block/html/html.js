// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    computed: {
      isValid() {
        return !!this.source.content;
      }
    }
  }
})();