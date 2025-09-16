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
          name: this.source?.name || '',
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
        }]
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
      }
    }
  }
})();