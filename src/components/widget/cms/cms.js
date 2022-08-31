// Javascript Document

(() => {
  return {
    props: {
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
