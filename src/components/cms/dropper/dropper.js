// Javascript Document

(() => {
  return {
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
    computed: {
      draggableCfg(){
        return {
          data: {
            type: 'cmsDropper',
            source: {
              type: this.type,
              special: this.special
            },
            cfg: this.defaultConfig,
            parendUid: this.$cid || false
          },
          mode: 'clone'
        }
      }
    }
  };
})();