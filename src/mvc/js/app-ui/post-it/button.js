(() => {
  return {
    methods: {
      toggle() {
        const postit = appui.getRegistered('postit');
        if (postit) {
          postit.toggle();
        }
      }
    }
  };
})();
