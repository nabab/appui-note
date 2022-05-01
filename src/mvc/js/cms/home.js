// Javascript Document

(() => {
  return {
    data() {
      return {
        types_notes: appui.getRegistered('cms').source.types_notes.map(a => {
          a.key = a.code;
          return a;
        })
      };
    }
  };
})();