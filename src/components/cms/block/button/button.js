(()=>{
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-note-cms-block']],
    props: {
      config: {
        type: Object
      }
    },
    data() {
      return {
        ignoredFields: ['content', 'url'],
        defaultConfig: {
          url: '',
          content: '',
          padding: 'bbn-xspadded',
          dimensions: '',
          align: 'left'
        },
      };
    }
  };
})();