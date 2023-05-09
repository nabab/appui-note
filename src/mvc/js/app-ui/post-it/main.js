(() => {
  let emptyPostIt = {
    content: '',
    color: '#fd4db0',
    title: '',
    creation: bbn.fn.dateSQL()
  };

  return {
    data() {
      return {
        postits: [emptyPostIt],
        showPostIt: false
      };
    },
    created() {
      appui.register('postit', this);
    },
    methods: {
      toggle() {
        this.showPostIt = !this.showPostIt;
      }
    }
  }
})();
