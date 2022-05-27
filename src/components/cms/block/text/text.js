// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data(){
      return {
        color: this.source.color || '#000',
        align: this.source.align || 'left'
      }
    },
    computed: {
      currentContent(){
        return this.source.content || '&nbsp;';
      },
      content: {
        get() {
          return this.source.content || '';
        },
        set(v) {
          this.setSource('content', v);
        }
      },
    },
    watch: {
      color(v) {
        this.setSource('color', v);
      },
      align(v) {
        this.setSource('align', v);
      }
    }
  }
})();