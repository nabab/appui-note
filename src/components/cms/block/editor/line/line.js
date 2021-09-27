// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, appui.mixins['appui-note-cms-editor']],
    computed: {
      data: {
        get() {
          return {
            data: {
              width: this.currentStyle.width || '100%',
              borderWidth: this.currentStyle.borderWidth || 1,
              borderStyle: this.currentStyle.borderStyle || 'solid',
              borderColor: this.currentStyle.borderColor || 'black',
              borderStyle: this.currentStyle.borderStyle || 'solid'
            }
          };
        },
        set(v) {
          bbn.fn.iterate(v, (a, n) => {
            let tmp = bbn.fn.camelToCss(n);
            if (this.source[tmp] !== undefined) {
              n = tmp;
            }
            if (this.source[n] !== a) {
              this.$set(this.source, n, a);
            }
          });
        }
      }
    }
  }
})();