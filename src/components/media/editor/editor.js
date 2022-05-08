// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent],
    props: {
      source: {
        type: Object
      },
      url: {
        type: String
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
      return {
        root: appui.plugins['appui-note'] + '/',
        ref: (new Date()).getTime(),
        currentFile: {
          name: this.source.name,
          size: this.source.content.size,
          extension: this.source.content.extension
        }
      };
    },
    computed: {
      currentFiles() {
        return [this.currentFile];
      },
      formattedSize() {
        return bbn.fn.formatBytes(this.currentFile.size);
      },
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
    }
  };
})();