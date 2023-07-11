// Javascript Document

(() => {
  return {
    mixins: [
      bbn.cp.mixins.basic,
      bbn.cp.mixins.input
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