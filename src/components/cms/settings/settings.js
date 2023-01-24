// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent],
    props: {
      source: {
        type: Object,
        required: true
      },
      typeNote: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
      };
    },
    methods: {
      emitClearCache() {
        this.$emit('clear');
      },
      close() {
        this.$emit('close');
      },
      save() {
        this.$emit('save');
      }
    },
  };
})();