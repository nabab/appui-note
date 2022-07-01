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
      },
      clearCache(file, all){
        if (!!file) {
          this.confirm(bbn._('Are you sure?'), () => {
            this.post(this.root + 'media/actions/clear_cache', {
              file: file,
              all: all
            }, d => {
              if (d.success) {
                let form = this.getRef('form')
                if (!!all) {
                  if (bbn.fn.isVue(form)) {
                    form.originalData.cacheFiles.splice(0);
                  }
                  this.source.cacheFiles.splice(0);
                }
                else {
                  let idx = bbn.fn.search(this.source.cacheFiles, {file: file});
                  if (idx > -1) {
                    if (bbn.fn.isVue(form)) {
                      idx = bbn.fn.search(form.originalData.cacheFiles, {file: file});
                      if (idx > -1) {
                        form.originalData.cacheFiles.splice(idx, 1);
                      }
                    }
                    this.source.cacheFiles.splice(idx, 1);
                  }
                }
                appui.success();
              }
              else {
                appui.error();
              }
            });
          })
        }
      },
      fdatetime(d){
        return dayjs.unix(d).format('DD/MM/YYYY HH:mm:ss')
      }
    }
  };
})();