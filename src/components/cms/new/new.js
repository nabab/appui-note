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
      }
    },
    data(){
      return {
        formData: {
          title: '',
          type: '',
          url: '',
          lang: bbn.env.lang,
          prefix: ''
        },
        root: appui.plugins['appui-note'] + '/'
      };
    },
    computed:{
      date(){
        return dayjs(dayjs().toISOString()).unix();
      },
    },
    methods: {
      updatePrefix() {
        bbn.fn.log("UPDATING PREFIX", this.formData.type)
        this.prefix = this.formData.type ? bbn.fn.getField(this.types, 'prefix', {value: this.formData.type}) : '';
      },
      afterSubmit(d) {
        if (d.success && d.data) {
          this.closest('bbn-floater').opener.getRef('table').reload();
          bbn.fn.link(this.root + 'cms/editor/' + d.data.id_note);
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