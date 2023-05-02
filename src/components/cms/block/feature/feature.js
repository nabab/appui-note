// Javascript Document

(() => {
  return {
    mixins: [bbn.wc.mixins.basic, bbn.wc.mixins['appui-note-cms-block']],
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