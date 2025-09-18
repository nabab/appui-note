(() => {
  return {
    props: {
      source: {
        type: Array,
        required: true
      },
      level: {
        type: Number,
        default: 0
      }
    },
    data(){
      return {
        selected: null
      }
    },
    computed: {
      selectedItems(){
        return this.selected?.items || [];
      }
    },
    methods: {
      selectField(field){
        if (navigator?.clipboard?.writeText) {
          navigator.clipboard.writeText(field.field).then(() => {
            appui.success(bbn._('Copied to clipboard'));
          });
        }

        if (field?.items?.length) {
          this.selected = this.selected === field ? null : field;
        }
      }
    }
  }
})();