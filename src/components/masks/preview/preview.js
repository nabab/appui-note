(() => {
  return {
    props: {
      source: {
        type: Object
      },
      model: {
        type: [Object, Boolean]
      }
    },
    data(){
      const inputsSource = {};
      if (this.model?.inputs) {
        bbn.fn.iterate(this.model.inputs, (input, field) => {
          inputsSource[field] = input.default !== undefined ? input.default : '';
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
        return !!Object.keys(this.inputsSource).length;
      }
    },
    methods: {
      onSubmit(){
        this.showPreview = false;
        this.$nextTick(() => {
          const args = {id: this.source.id_note};
          bbn.fn.iterate(this.inputsSource, (value, key) => {
            args[key] = value;
          });
          this.previewUrl = this.root + 'masks/actions/preview?' + new URLSearchParams(args).toString();
          this.showPreview = true;
        });
      }
    }
  }
})();