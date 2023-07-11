// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-note-cms-block']],
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