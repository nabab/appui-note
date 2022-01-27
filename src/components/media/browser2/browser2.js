// Javascript Document
(()=>{
  return{
    mixins: [bbn.vue.basicComponent],
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
      edit: {
        type: [Boolean, String],
        default: true
      },
      detail: {
        type: String
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
        type: [String, Object, Vue]
      },
      url: {
        type: String
      },
      single: {
        type: Boolean,
        default: false
      },
      toolbarButtons: {
        type: Array
      }
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
      downloadEnabled(){
        return !!this.download && (!!this.url || bbn.fn.isString(this.download));
      },
      uploadEnabled(){
        return !!this.upload && (!!this.url || bbn.fn.isString(this.upload));
      },
      removeEnabled(){
        return !!this.remove && (!!this.url || bbn.fn.isString(this.remove));
      },
      editEnabled(){
        return !!this.edit && (!!this.url || bbn.fn.isString(this.edit));
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
      getButtonMenu(data){
        let res = [];
        if (this.detail) {
          res.push({
            text: bbn._('Info'),
            icon: 'nf nf-fa-info',
            action: () => {
              this.openDetail(data);
            }
          });
        }
        if (this.editEnabled) {
          res.push({
            text: bbn._('Edit'),
            icon: 'nf nf-fa-edit',
            action: () => {
              this.editMedia(data);
            }
          });
        }
        if (this.downloadEnabled) {
          res.push({
            text: bbn._('Download'),
            icon: 'nf nf-fa-download',
            action: () => {
              this.downloadMedia(data);
            }
          });
        }
        if (this.removeEnabled) {
          res.push({
            text: bbn._('Delete'),
            icon: 'nf nf-fa-trash',
            action: () => {
              this.removeMedia(data);
            }
          });
        }
        return res;
      },
      editMedia(m){
        if (this.editEnabled) {
          if(bbn.fn.isString(m.content)){
            m.content = JSON.parse(m.content)
          }
          this.getPopup().open({
            title: bbn._('Edit media'),
            component: 'appui-note-media-form',
            componentOptions: {
              source: m,
              multiple: false,
              url: this.edit || this.url
            },
            height: '400px',
            width: '500px',
            onOpen: pop => {
              pop.$on('edited', this.onEdited);
            }
          });
        }
      },
      addMedia(){
        if (this.uploadEnabled) {
          this.getPopup().open({
            title: bbn._('Add new media'),
            component: 'appui-note-media-form',
            componentOptions: {
              source: {},
              url: this.upload || this.url
            },
            height: '400px',
            width: '500px',
            onOpen: pop => {
              pop.$on('added', this.onAdded);
            }
          });
        }
      },
      onAdded(media){
        let gallery = this.getRef('gallery');
        if (!gallery.isAjax) {
          if (bbn.fn.isArray(media)) {
            gallery.source.push(...media);
          }
          else {
            gallery.source.push(media);
          }
        }
        gallery.updateData();
        appui.success(bbn._('Media(s) successfully added'));
      },
      onEdited(media){
        let gallery = this.getRef('gallery');
        if (!gallery.isAjax) {
          let idx = bbn.fn.search(gallery.source, {id: media.id});
          if (idx > -1) {
            gallery.source.splice(idx, 1, media);
          }
        }
        gallery.updateData();
        appui.success(bbn._('Media successfully edited'));
      },
      openDetail(media){
        if (media && media.id && this.detail) {
          bbn.fn.link(this.detail + (this.detail.substr(-1, 1) !== '/' ? '/' : '') + media.id);
        }
      },
      formatBytes: bbn.fn.formatBytes,
      removeMedia(m){
        this.$emit('delete', {
          id_note: !!this.data && !!this.data.id_note ? this.data.id_note : false,
          media: m
        });
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
        this.$emit('download', a)
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
        this.$emit('selection', a)
      },
      emitClickItem(item) {
        this.$emit('clickItem', item)
      },
      showImage(img){
        this.getPopup().open({
          title: ' '/*img.name*/,
          source: img,
          content: '<div class="bbn-overlay bbn-middle"><img src="' + appui.plugins['appui-note'] + '/media/image/' + img.id + '/' + img.content.path + '" style="max-width: 100%; max-height: 100%"></div>',
          height: '70%',
          width: '70%',
          scrollable: false
        })
      },
      showFileInfo(m){
        this.getPopup().open({
          title: m.title,
          source: m,
          component: 'appui-note-media-info',
          width: 400,
        })
      },
      refresh(){
        this.getRef('gallery').updateData();
      }
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
        this.medias = bbn.fn.filter(this.currentData, (a) => {
          return a.title.toLowerCase().indexOf(val.toLowerCase()) > -1;
        });
      }
    }
  }
})();