// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-reader']],
    computed: {
      youtube(){
        return this.source.src.indexOf('youtube') > -1
      },
    }
  }
})();