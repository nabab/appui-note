// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data() {
      return {
        defaultConfig: {
          align: '',
          color: '',
        }
      }
    },
    computed: {
      currentContent(){
        return this.currentSource.content || '&nbsp;';
      },
      content: {
        get() {
          return this.currentContent;
        },
        set(v) {
          this.setSource('content', v);
        }
      },
    }
  }
})();