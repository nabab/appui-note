(() => {
  return {
    data(){
      return {
        root: appui.plugins['appui-note'] + '/'
      }
    },
    methods: {
      setOn(){
        this.getRef('form').$on('edited', () => {
          appui.success();
          this.closest('bbn-container').reload();
        });
      }
    }
  };
})();