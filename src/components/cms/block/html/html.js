// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-note-cms-block']],
    data() {
      return {
        defaultConfig: {
          content: ''
        }
      };
    },
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