(() => {
  return {
    data() {
      return {
        postits: [],
        showPostIt: false,
        hasBeenShown: false
      };
    },
    created() {
      appui.register('postit', this);
    },
    methods: {
      toggle() {
        this.showPostIt = !this.showPostIt;
        if (this.showPostIt && !this.hasBeenShown) {
          this.hasBeenShown = true;
          this.updatePostIts();
        }
      },
      updatePostIts() {
        bbn.fn.post(appui.plugins['appui-note'] + '/data/postits', {pinned: 0}, d => {
          if (d && d.data) {
            this.postits = d.data;
          }
        })
      }
    }
  }
})();
