// Javascript Document

(() => {
  return {
    props: {
      source: {
        type: Object
      },
      start: {
        type: Boolean,
        default: false
      },
      end: {
        type: Boolean,
        default: false
      }
    },
    data(){
      return {
        root: appui.plugins['appui-note'] + '/'
      };
    },
    methods: {
      fdate: bbn.fn.fdate
    }
  };
})();
