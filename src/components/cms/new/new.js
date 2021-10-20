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
      let ct = this.closest('bbn-container').getComponent();
      return {
        formData: {
          title: '',
          type: this.types[0].value,
          url: '',
          lang: bbn.env.lang
        },
        urlEdited: false,
        root: appui.plugins['appui-note'] + '/'
      };
    },
    computed:{
      date(){
        return moment(moment().toISOString()).unix();
      },
      url() {
        return this.makeURL(this.formData.title);
      }
    },
    methods: {
      makeURL(st) {
        if (st) {
          return bbn.fn.sanitize(st, '-').toLowerCase();
        }

        return '';
      },
      afterSubmit(d) {
        if ( d.success && d.data){
          this.closest('bbn-floater').opener.getRef('table').reload();
          bbn.fn.link(this.root + 'cms/editor/' + d.data.id_note);
        }
      }
    },
    watch: {
      url(v) {
        if (!this.urlEdited) {
          this.formData.url = v;
        }
      },
      "formData.url"(v) {
        if ((v === null) || (this.makeURL(v) === this.url)) {
          if (this.urlEdited) {
            this.urlEdited = false;
            this.formData.url = this.url;
          }
        }
        else if (!this.urlEdited) {
          this.urlEdited = true;
        }
      },
      publish(val){
        if ( !val ){
          this.source.start = null;
          this.source.end = null;
        }
        else{
          if ( !this.source.start ){
            this.source.start = moment().format("YYYY/MM/DD HH:mm:ss");
          }
        }
      }
    }
  }
})();