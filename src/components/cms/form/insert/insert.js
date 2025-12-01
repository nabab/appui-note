// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
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
        pref: this.id_type ? bbn.fn.getField(this.types, 'prefix', {id: this.id_type}) : '',
        root: appui.plugins['appui-note'] + '/'
      };
    },
    computed:{
      date(){
        return bbn.dt(bbn.dt().toISOString()).unix();
      }
    },
    methods: {
      updatePrefix() {
        this.pref = this.formData.type ? bbn.fn.getField(this.types, 'prefix', {id: this.formData.type}) : '';
      },
      afterSubmit(d) {
        if (d.success && d.data) {
          if (d.data.id_note) {
            let code = bbn.fn.getField(this.types, 'code', {id: this.formData.type});
            this.closest('bbn-floater').opener.getRef('table').reload();
            bbn.fn.link(this.root + 'cms/cat/' + code + '/editor/' + d.data.id_note);
          }
        }
      },
      addCategory(){
        this.getPopup({
          label: bbn._('New Category'),
          width: 500,
          component: 'appui-note-cms-form-category',
          componentOptions: {
            types: this.types,
            source: {
              text: '',
              code: '',
              front_img: 0,
              prefix: ''
            }
          }
        })
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
            this.source.start = bbn.dt().format("YYYY/MM/DD HH:mm:ss");
          }
        }
      }
    }
  }
})();