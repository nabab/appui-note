// Javascript Document

(() => {
  return {
    mixins: [
      bbn.wc.mixins.basic,
      bbn.wc.mixins.input
    ],
    props: {
      placeholder: {
        type: String,
        default: bbn._('Search for a note')
      },
      types: {
        type: Array,
        default() {
          return [];
        }
      }
    },
    data() {
      return {
        root: appui.plugins['appui-note'] + '/'
      };
    },
    methods: {
      select(data) {
        this.$emit("select", data);
      }
    }
  };
})();