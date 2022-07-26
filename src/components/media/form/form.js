(() => {
  return {
    mixins: [bbn.vue.basicComponent],
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
      if (!!this.source
        && !!this.source.id &&
        !!this.source.id.length
      ) {
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
        files: files,
        showTitles: false,
        oldTitle: '',
        oldDescription: '',
      };
    },
    computed: {
      isMediaGroup(){
        return (this.closest('bbn-container').find('appui-note-media-groups') !== undefined) || false
      },
      isEdit(){
        return !!this.source && !!this.source.id && !!this.source.id.length;
      },
      asJson(){
        return !!this.source && !!this.source.content && bbn.fn.isString(this.source.content);
      },
      idGroup(){
        if(this.isMediaGroup){
          return this.closest('bbn-container').find('appui-note-media-groups').current.id
        }
      }
    },
    methods: {
      success(d){
        if (d.success && d.media) {
          let floater = this.closest('bbn-floater');
          if (bbn.fn.isVue(floater)) {
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
      'source.link'(val){
        this.files[0].link = val;
      },
      files(newVal, oldVal){
        if (this.isEdit && !oldVal.length) {
          newVal[0].title = this.oldTitle;
          newVal[0].description = this.oldDescription;
          this.oldTitle = '';
          this.oldDescription = '';
        }
      }
    },
    mounted(){
      if(this.isMediaGroup){
        this.files[0].link = this.source.link;
      }
    }
  };
})();