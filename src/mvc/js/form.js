(() => {
  return {
    data(){
      return {
        root: appui.plugins['appui-note'] + '/',
        editor: 'bbn-textarea',
        editors: [{
          text: 'Textarea',
          value: 'bbn-textarea'
        }, {
          text: 'RTE',
          value: 'bbn-rte'
        }, {
          text: 'Markdown',
          value: 'bbn-markdown'
        }],
        formData: {
          id_type: null,
          title: '',
          content: '',
          mime: '',
          lang: '',
          private: 0,
          locked: 0,
          pinned: 0,
          url: '',
          start: '',
          end: ''
        }
      }
    },
    computed:{
      languages(){
        let ret = [];
        if (this.source.languages) {
          bbn.fn.iterate(this.source.languages, l => ret.push({text: l.text, value: l.code}));
        }
        return ret;
      }
    },
    methods: {
      afterSubmit(d) {
        if (d.success) {
          appui.success();
          this.reset();
        }
        else {
          appui.error();
        }
      },
      reset(){
        this.formData.id_type = null;
        this.formData.title = '';
        this.formData.content = '';
        this.formData.mime = '';
        this.formData.lang = '';
        this.formData.private = 0;
        this.formData.locked = 0;
        this.formData.pinned = 0;
        this.formData.url = '';
        this.formData.start = '';
        this.formData.end = '';
      }
    },
    watch: {
      'formData.start'(val){
        if (!val) {
          this.formData.end = '';
        }
      }
    }
  }
})();