(() => {
  return {
    props: {
      source: {
        type: Object
      },
      inputs: {
        type: [Object, Boolean]
      }
    },
    data(){
      const inputsSource = {};
      if (this.inputs && Object.keys(this.inputs).length) {
        bbn.fn.iterate(this.inputs, (input, field) => {
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
        const inputs = this.inputs ? Object.keys(this.inputs).length : 0;
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
          this.previewUrl = this.root + 'actions/masks/preview?' + new URLSearchParams(args).toString();
          this.showPreview = true;
        });
      },
      onCancel(){
        this.showPreview = false;
      }
    }
  }
})();