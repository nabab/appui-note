// Javascript Document

(() => {
  return {
    computed: {
      blocks() {
        return appui.getRegistered('cms').source.blocks;
      },
      pblocks() {
        return appui.getRegistered('cms').source.pblocks;
      }
    }
  }
})();