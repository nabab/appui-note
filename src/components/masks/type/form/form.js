(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    data(){
      return {
        formSource: {
          id: this.source?.id || '',
          text: this.source?.text || '',
          code: this.source?.code || '',
          preview: this.source?.preview || false,
          preview_model: this.source?.preview_model || '',
          preview_inputs: this.source?.preview_inputs || [],
          fields: this.source?.fields || []
        },
        previewTypes: [{
          text: bbn._('None'),
          value: false
        }, {
          text: bbn._('Model'),
          value: 'model'
        }, {
          text: bbn._('Custom'),
          value: 'custom'
        }],
        isAddingInput: false,
        isEditingInput: false,
        isAddingField: false,
        isEditingField: false
      }
    },
    methods: {
      onSuccess(d){
        if (d.success) {
          appui.success();
          this.$emit('success', true);
        }
        else {
          appui.error(d.error || bbn._('An error occurred'));
        }
      },
      onFailure(d){
        appui.error(d.error || bbn._('An error occurred'));
      },
      onInputSaved(d){
        if (this.isAddingInput) {
          this.formSource.preview_inputs.push(d);
          this.isAddingInput = false;
        }
        else if (this.isEditingInput) {
          bbn.fn.iterate(d, (v, i) => {
            this.isEditingInput[i] = v;
          });

          this.isEditingInput = false;
        }
      },
      onFieldSaved(d){
        if (this.isAddingField) {
          this.formSource.fields.push(d);
          this.isAddingField = false;
        }
        else if (this.isEditingField) {
          bbn.fn.iterate(d, (v, i) => {
            this.isEditingField[i] = v;
          });

          this.isEditingField = false;
        }
      }
    },
    watch: {
      previewTypes(nv){
        switch (nv) {
          case 'model':
            this.formSource.preview_inputs = [];
            this.formSource.fields = [];
            break;
          case 'custom':
            this.formSource.preview_model = '';
            break;
          default:
            this.formSource.preview_model = '';
            this.formSource.preview_inputs = [];
            this.formSource.fields = [];
            break;
        }
      }
    }
  }
})();