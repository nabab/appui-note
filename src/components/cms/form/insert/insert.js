// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent],
    props: {
      noteName: {
        type: String,
        default: bbn._("Note")
      },
      types: {
        required: true,
        type: Array
      },
      id_type: {
        type: String
      }
    },
    data(){
      return {
        formData: {
          title: '',
          type: this.id_type || '',
          url: '',
          lang: bbn.env.lang,
          excerpt: ''
        },
        prefix: this.id_type ? bbn.fn.getField(this.types, 'prefix', {id: this.id_type}) : '',
        root: appui.plugins['appui-note'] + '/'
      };
    },
    computed:{
      date(){
        return dayjs(dayjs().toISOString()).unix();
      }
    },
    methods: {
      updatePrefix() {
        this.prefix = this.formData.type ? bbn.fn.getField(this.types, 'prefix', {id: this.formData.type}) : '';
      },
      afterSubmit(d) {
        if (d.success && d.data) {
          if (d.data.id_note) {
            let code = bbn.fn.getField(this.types, 'code', {id: this.formData.type});
            bbn.fn.log("CODE??", code);
            this.closest('bbn-floater').opener.getRef('table').reload();
            bbn.fn.link(this.root + 'cms/cat/' + code + '/editor/' + d.data.id_note);
          }
        }
      }
    },
    watch: {
      "formData.type"() {
        this.updatePrefix();
      },
      publish(val){
        if ( !val ){
          this.source.start = null;
          this.source.end = null;
        }
        else{
          if ( !this.source.start ){
            this.source.start = dayjs().format("YYYY/MM/DD HH:mm:ss");
          }
        }
      }
    }
  }
})();