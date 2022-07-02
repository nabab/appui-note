// Javascript Document

(() => {
  return {
    mixins: [
      bbn.vue.basicComponent,
      bbn.vue.inputComponent
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
      select(ev, data) {
        this.$emit("select", data);
      }
    }
  };
})();