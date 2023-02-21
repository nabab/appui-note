// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: {
      config: {
        type: Object
      }
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
          align: 'left',
          color: '',
          fontStyle: 'normal',
          textDecoration: 'none'
        }
      };
    },
    computed: {
      currentStyle(){
        return {
          textAlign: this.source.align || undefined,
          color: this.source.color || undefined,
          textDecoration: this.source.decoration || undefined,
          fontStyle: !!this.source.fontStyle || undefined
        };
      }
    },
  };
})();