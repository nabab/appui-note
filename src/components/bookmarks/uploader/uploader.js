// Javascript Document

(() => {
  return {
    props: {

    },
    data() {
      return {
        root: appui.plugins['appui-note'] + '/',
        bookmarksName: "bookmarks.html",
      };
    },
    methods: {
      success() {
        this.closest('bbn-container').reload();
      },
    },
  }
})();