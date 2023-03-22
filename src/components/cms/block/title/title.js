// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: {
      config: {
        type: Object
      },
    },
    data() {
      return {
        tags: ['h1', 'h2', 'h3', 'h4', 'h5'].map(a => {
          return {
            text: bbn._("Title") + ' ' + a,
            value: a
          };
        }),
        defaultConfig: {
          tag: 'h1',
          content: '',
          align: '',
          color: '',
          fontStyle: '',
          textDecoration: ''
        }
      };
    },
    computed: {
      currentStyle() {
        const st = {};
        if (this.currentSource.align) {
          st.textAlign = this.currentSource.align;
        }
        if (this.currentSource.color) {
          st.color = this.currentSource.color;
        }
        if (this.currentSource.textDecoration) {
          st.textDecoration = this.currentSource.textDecoration;
        }
        if (this.currentSource.fontStyle) {
          st.fontStyle = this.currentSource.fontStyle;
        }
        return st;
      }
    }
  };
})();