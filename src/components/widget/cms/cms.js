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
    computed: {
      isPublished() {
        const d = bbn.fn.dateSQL();
        if (this.source.start && (this.source.start <= d)) {
          if (this.source.end && (this.source.end <= d)) {
            return false;
          }
          return true;
        }

        return false;
      }
    },
    methods: {
      fdate: bbn.fn.fdate
    }
  };
})();
