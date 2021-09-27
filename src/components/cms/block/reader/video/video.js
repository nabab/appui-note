// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, appui.mixins['appui-note-cms-reader']],
    computed: {
      youtube(){
        return this.source.src.indexOf('youtube') > -1
      },
    }
  }
})();