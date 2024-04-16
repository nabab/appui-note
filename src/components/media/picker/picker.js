// Javascript Document
(()=>{
  return{
    mixins: [bbn.cp.mixins.basic],
    props: {
      searchName: {
        type: String,
        default: 'title'
      },
      mediaType: {
        type: String,
        default: null
      },
      source: {
        type: [String, Array]
      },
      data: {
        type: Object
      },
      limit: {
        type: Number,
        default: 25
      },
      upload: {
        type: [Boolean, String],
        default: true
      },
      download: {
        type: [Boolean, String],
        default: true
      },
      remove: {
        type: [Boolean, String],
        default: true
      },
      pageable: {
        type: Boolean,
        default: true
      },
      filterable: {
        type: Boolean,
        default: true
      },
      zoomable: {
        type: Boolean,
        default: true
      },
      info: {
        type: Boolean,
        default: true
      },
      pathName: {
        type: String
      },
      overlay: {
        type: Boolean,
        default: true
      },
      overlayName: {
        type: String
      },
      selection: {
        type: Boolean,
        default: true
      },
      clickItem: {
        type: Boolean,
        default: true
      },
      buttonMenu: {
        type: [Array, Function]
      },
      buttonMenuComponent: {
        type: [String, Object]
      },
      url: {
        type: String
      },
      single: {
        type: Boolean,
        default: false
      },
    },
    data(){
      return {
        cp: this,
        searchMedia: '',
        current: {},
        showList: false,
        isPicker: false,
         root: appui.plugins['appui-note'] + '/',
      }
    },
    computed: {
      currentButtonMenu(){
        if (this.buttonMenu) {
          return this.buttonMenu;
        }
        let res = [];
        if (this.downloadEnabled) {
          res.push({
            text: bbn._('Download'),
            icon: 'nf nf-fa-download',
            action: this.downloadMedia
          })
        }
        if (this.removeEnabled) {
          res.push({
            text: bbn._('Delete'),
            icon: 'nf nf-fa-trash',
            action: this.removeMedia
          })
        }
        return res;
      },
      downloadEnabled(){
        return !!this.download && (!!this.url || bbn.fn.isString(this.download));
      },
      uploadEnabled(){
        return !!this.upload && (!!this.url || bbn.fn.isString(this.upload));
      },
      removeEnabled(){
        return !!this.remove && (!!this.url || bbn.fn.isString(this.remove));
      },
      extensions() {
        let res = [];
        bbn.fn.each(bbn.opt.extensions, (v, i) => {
          res.push(v.code.toLowerCase())
        })
        return res;
      }
    },
    methods: {
      editMedia(m, a){
        if(bbn.fn.isString(m.content)){
          m.content = JSON.parse(m.content)
        }
        this.getPopup().open({
          title: bbn._('Edit media'),
          component: 'appui-note-media-form',
          componentOptions: {
            source: {
              media: m,
              edit: true,
              removedFile: false,
              oldName: ''
            },
            browser: this
          },
          height: '400px',
          width: '400px',
        })
      },
      addMedia(){
        this.getPopup().open({
          title: bbn._('Add new media'),
          component: 'appui-note-media-form',
          componentOptions: {
            source: {
              media: {
                title: '',
                file: [],
                name: ''
              }
            },
            browser: this
          },
          height: '400px',
          width: '400px'
        });
      },
      formatBytes: bbn.fn.formatBytes,
      removeMedia(m){
        this.$emit('delete', {'id_note':this.data.id_note, 'media': m} );
        /*this.confirm(
          (m.notes && m.notes.length) ?
	          bbn._("The media you're going to delete is linked to a note, are you sure you want to remove it?") :
          	bbn._("Are you sure you want to delete this media?"),
          () => {
            this.$emit('delete', {'id_note':this.data.id_note, 'id': m.id} );
            this.post(
              appui.plugins['appui-note'] + '/media/actions/delete',
              m,
              (d) => {
                if (d.success){
                  let idx = bbn.fn.search(this.currentData, {id: m.id});
                  if (idx > -1) {
                    this.currentData.splice(idx, 1);
                  }
                  appui.success(bbn._('Media successfully deleted :)'))
                }
                else{
                  appui.error(bbn._('Something went wrong while deleting the media :('))
                }
              }
            )
          }
        )*/
      },
      downloadMedia(a, b){
        this.$emit('download', a);
       /* this.post(this.root + 'media/actions/file/download', a, (d) => { 
          if(d.success){
            appui.success(a.name +' '+ bbn._( +'downloaded'))
          }
          else{
            appui.error(bbn._('Something went wrong while downloading the file'))
          }
        })*/
      },
      selectMedia(a){
        this.$emit('selection', a);
      },
      emitClickItem(item) {
        bbn.fn.log("EMITTING CLICKITEM");
        this.$emit('clickitem', item);
      },
      showImage(img){
        this.getPopup().open({
          title: ' '/*img.name*/,
          source: img,
          content: '<div class="bbn-overlay bbn-middle"><img src="' + appui.plugins['appui-note'] + '/media/image/' + img.id + '/' + img.content.path + '" style="max-width: 100%; max-height: 100%"></div>',
          height: '70%',
          width: '70%',
          scrollable: false
        });
      },
      showFileInfo(m){
        this.getPopup().open({
          title: m.title,
          source: m,
          component: 'appui-note-media-info',
          width: 400,
        });
      },
    },
    beforeMount(){
      /** @todo WTF?? */
      if (this.closest('bbn-router').selectingMedia) {
        this.isPicker = true;
      }
    },
    mounted(){
      this.ready = true;
    },
    watch: {
      searchMedia(val){
        bbn.fn.error('watch');
        bbn.fn.happy(a.title.toLowerCase().indexOf(val.toLowerCase()));
        this.medias = bbn.fn.filter(this.currentData, (a) => {
          return a.title.toLowerCase().indexOf(val.toLowerCase()) > -1;
        })
      }
    }
  }
})();