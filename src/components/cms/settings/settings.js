// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
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