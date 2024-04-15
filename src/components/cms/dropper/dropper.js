// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: {
      title: {
        type: String,
        required: true
      },
      type: {
        type: String,
        required: true
      },
      icon: {
        type: String,
      },
      defaultConfig: {
        type: Object,
      },
      description: {
        type: String
      },
      special: {
        type: String
      }
    },
    data(){
      return {
        cid: this.$cid
      };
    }
  };
})();