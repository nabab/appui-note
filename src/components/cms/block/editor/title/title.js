// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, appui.mixins['appui-note-cms-editor']],
    data(){
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
      tag(){
        return this.source.tag || 'h1';
      }
    },
    components: {
      tag: {
        props: ['source'],
        template: '<component :is="source.value" v-text="source.text"/>'
      }
    }
  }
})();