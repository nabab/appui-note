(() => {
  return {
    props: {
      source: {
        type: [String, Array]
      },
      url: {
        type: String
      }
    },
    data(){
      return {
        cp: appui.getRegistered('appui-note-cms-list'),
        formData: {
          type: '',
          id: this.source
        }
      }
    },
    methods:{
      onSuccess(d){
        if (d.success) {
          appui.success(d.message || '');
        }
        else {
          appui.error();
        }

        if (bbn.fn.isArray(this.source)
          && !!this.cp
          && this.cp.getRef('table')
        ) {
          this.cp.getRef('table').currentSelected.splice(0);
        }

        this.cp.updateData();
      }
    }
  }
})();