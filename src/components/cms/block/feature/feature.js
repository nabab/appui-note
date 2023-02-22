// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: {
      details: {
        type: Boolean,
        default: true
      }
    },
    data() {
      return {
        content: ''
      }
    }
  };
})();