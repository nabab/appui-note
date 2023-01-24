// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: {
      defaultConfig: {
        type: Object,
        default() {
          return {
            tag: 'h1',
            content: 'hello',
            align: 'left',
            hr: null,
            style: {
              'text-decoration': 'none',
              'font-style': 'normal',
              color: '#000000'
            }
          };
        }
      }
    },
    data() {
      return {
        tags: ['h1', 'h2', 'h3', 'h4', 'h5'].map(a => {
          return {
            text: bbn._("Title") + ' ' + a,
            value: a
          };
        })
      };
    },
    computed: {
      style(){
        return bbn.fn.extend(true, {
          textAlign: this.source.align || 'left',
          //color: this.source.color || undefined,
          //textDecoration: this.source.decoration || undefined,
          //fontStyle: !!this.source.italic ? 'italic' : 'normal'
        }, this.source.style);
      }
    },
    watch: {
      'this.source'() {
        bbn.fn.log('changes in source', this.source);
      }
    },
  };
})();