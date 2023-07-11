// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-note-cms-block']],
    data(){
      return {
        color: this.source.color || '#000',
        align: this.source.align || 'left'
      }
    },
    computed: {
      currentContent(){
        return this.source.content || (this.$parent.selectable && (this.mode === 'read') ? '' : '&nbsp;');
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
