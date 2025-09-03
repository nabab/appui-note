// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: {
      source: {
        type: Object
      },
      multiple: {
        type: Boolean,
        default: true
      },
      url: {
        type: String,
        required: true
      },
      scrollable: {
        type: Boolean,
        default: false
      },
      buttons: {
        type: Array,
        default(){
          return ['cancel', 'submit']
        }
      }
    },
    data(){
      let files = [];
      if (this.source?.id?.length) {
        files.push({
          name: this.source.name,
          title: this.source.title,
          description: this.source.description,
          extension: this.source.content.extension,
          size: this.source.content.size
        });
      }
      return {
        root: appui.plugins['appui-note'] + '/',
        ref: (new Date()).getTime(),
        files,
        showTitles: false,
        oldTitle: '',
        oldDescription: '',
      };
    },
    computed: {
      isEdit(){
        return !!this.source && !!this.source.id && !!this.source.id.length;
      },
      asJson(){
        return !!this.source && !!this.source.content && bbn.fn.isString(this.source.content);
      }
    },
    methods: {
      success(d){
        if (d.success && d.media) {
          let floater = this.closest('bbn-floater');
          if (bbn.cp.isComponent(floater)) {
            floater.$emit(this.isEdit ? 'edited' : 'added', d.media);
          }
          this.$emit(this.isEdit ? 'edited' : 'added', d.media);
        }
        else{
          appui.error(bbn._('Something went wrong while saving the media'));
        }
      },
      onRemove(ev, file){
        this.oldTitle = file.data.title;
        this.oldDescription = file.data.description;
      }
    },
    watch: {
      showTitles(newVal){
        if (!this.isEdit && !newVal) {
          bbn.fn.each(this.files, f => f.title = '');
        }
      },
      files(newVal, oldVal){
        if (this.isEdit) {
          if (!oldVal.length) {
            newVal[0].title = this.oldTitle;
            newVal[0].description = this.oldDescription;
            this.oldTitle = '';
            this.oldDescription = '';
          }
        }
      }
    }
  };
})();