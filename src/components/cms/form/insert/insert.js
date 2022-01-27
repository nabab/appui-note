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
      prefix: {
        type: String,
        default: ''
      }
    },
    data(){
      return {
        formData: {
          title: '',
          type: this.types[0].value,
          url: '',
          lang: bbn.env.lang
        },
        root: appui.plugins['appui-note'] + '/'
      };
    },
    computed:{
      date(){
        return dayjs(dayjs().toISOString()).unix();
      }
    },
    methods: {
      afterSubmit(d) {
        if (d.success && d.data) {
          this.closest('bbn-floater').opener.getRef('table').reload();
          bbn.fn.link(this.root + 'cms/editor/' + d.data.id_note);
        }
      }
    },
    watch: {
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