// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-editor']],
    data() {
      return {
        tags: ['h1', 'h2', 'h3', 'h4', 'h5'].map(a => {
          return {
            text: bbn._("Title") + ' ' + a,
            value: a
          };
        }),
        color: this.source.color
      };
    },
    computed: {
      tag(){
        return this.source.tag || 'h1';
      }
    },
    watch: {
      color(v) {
        this.$set(this.source.style, "color", v)
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