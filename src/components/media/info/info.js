// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: ['source'],
    data(){
      return {
        root: appui.plugins['appui-note'] + '/',
        users: appui.users
      };
    },
    computed: {
      hasImage() {
        return this.source.is_image && this.source.thumbs && this.source.thumbs.length && (this.source.thumbs[0] < 200);
      },
      imageSrc() {
        if (this.hasImage) {
          let thumbs = this.source.thumbs.filter(a => a < 200);
          return this.root + 'media/image/' + this.source.id + '?w=' + thumbs.pop();
        }

        return '';
      },
      type() {
        if (!this.source.type || !appui.options.media_types) {
          return '';
        }

        let arr = bbn.fn.isObject(appui.options.media_types) ? Object.values(appui.options.media_types) : appui.options.media_types;
        return bbn.fn.getField(arr, 'text', {id: this.source.type});
      }
    },
    methods: {
      copyPath() {
        bbn.fn.copy(this.source.path);
      },
      copyId() {
        bbn.fn.copy(this.source.id);
      },
      copyFile() {
        bbn.fn.copy(this.source.file);
      },
      openDetails() {
        this.getPopup({
          title: false,
          url: this.root + 'media/detail/' + this.source.id,
          width: '100%',
          height: '100%'
        }).then(() => {
          let floater = this.closest('bbn-floater');
          if (floater) {
            floater.close();
          }
        });
      },
      show_note_content(n){
        this.getPopup().open({
          title: n.title,
          content: n.content
        });
      },
      formatBytes: bbn.fn.formatBytes,
      getField: bbn.fn.getField,
      clearCache(file, all){
        if (!!file) {
          this.confirm(bbn._('Are you sure?'), () => {
            this.post(this.root + 'media/actions/clear_cache', {
              file: file,
              all: all
            }, d => {
              if (d.success) {
                if (!!all) {
                  this.source.cacheFiles.splice(0);
                }
                else {
                  let idx = bbn.fn.search(this.source.cacheFiles, {file: file});
                  if (idx > -1) {
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
  }
})();