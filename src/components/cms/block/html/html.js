// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    computed: {
      isValid() {
        return !!this.source.content;
      },
      style(){
        let style = bbn.fn.extend(true, {}, this.source.style);
        if (this.source.align) {
          style['text-align'] = this.source.align;
        }
        return style;
      }
    }
  }
})();