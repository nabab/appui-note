// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
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
        }, this.source.style)
      }
    }
  }
})();