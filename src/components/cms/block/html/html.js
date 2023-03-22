// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data() {
      return {
        defaultConfig: {
          content: ''
        }
      };
    },
    computed: {
      isValid() {
        return !!this.currentSource.content;
      },
      style(){
        let style = bbn.fn.extend(true, {}, this.currentSource.style);
        if (this.currentSource.align) {
          style['text-align'] = this.currentSource.align;
        }
        return style;
      }
    }
  }
})();