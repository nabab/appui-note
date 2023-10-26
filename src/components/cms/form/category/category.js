(() => {
  return {
    props: {
      source: {
        type: Object,
        required: true
      },
      types: {
        type: Array,
        required: true
      }
    },
    data(){
      return {
        root: appui.plugins['appui-note'] + '/'
      }
    },
    methods: {
      onSuccess(d){
        if (!!d.success && !!d.data) {
          if (!!this.source.id) {
            let obj = bbn.fn.getRow(this.types, 'id', this.source.id);
            if (obj) {
              bbn.fn.iterate(d.data, (v, k) => {
                this.$set(obj, k, v);
              });
            }
          }
          else {
            this.types.push(d.data);
            if (this.getRef('form')?.window?.opener?.formData?.id_type !== undefined) {
              this.getRef('form').window.opener.formData.id_type = d.data.id;
            }
          }

          appui.success();
        }
        else {
          appui.error();
        }
      }
    }
  }
})();
