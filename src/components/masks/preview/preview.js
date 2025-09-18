(() => {
  return {
    props: {
      source: {
        type: Object
      },
      inputs: {
        type: [Array, Boolean],
        default(){
          return [];
        }
      }
    },
    data(){
      const inputsSource = {};
      if (this.inputs?.length) {
        bbn.fn.each(this.inputs, input => {
          inputsSource[input.field] = input.default !== undefined ? input.default : (input.componentOptions?.default !== undefined ? input.componentOptions.default : '');
        });
      }

      return {
        inputsSource,
        showPreview: false,
        previewUrl: ''
      }
    },
    computed: {
      hasInputs(){
        const inputs = this.inputs?.length || 0;
        const inpurtsSource = Object.keys(this.inputsSource).length;
        return inputs && inpurtsSource && (inputs === inpurtsSource);
      }
    },
    methods: {
      onSubmit(ev){
        ev.preventDefault();
        this.showPreview = false;
        this.$nextTick(() => {
          const args = {
            _id: this.source.id_note,
            _type: this.source.id_type
          };
          bbn.fn.iterate(this.inputsSource, (value, key) => {
            args[key] = value;
          });
          this.previewUrl = this.root + 'actions/masks/preview?hash=' + encodeURI(btoa(JSON.stringify(args)));
          this.showPreview = true;
        });
      },
      onCancel(){
        this.showPreview = false;
      }
    }
  }
})();