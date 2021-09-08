// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent],
    props: ['source', 'data'],
    data(){
      return {
        icons: {
          pdf: 'nf nf-fa-file_pdf_o',
          docx: 'nf nf-mdi-file_document',
          xls: 'nf nf-fa-file_excel_o',
          odt: 'nf nf-mdi-file_word'
        },
        cp: {},
        adjustTop: '',
        adjustWidth: '',
        canShow: false,
        editinline:false,
        initialTitle: '',
        root: appui.plugins['appui-note'] + '/',
        select: '',
        removedFile: false,
      }
    },
    computed: {
      isMobile: bbn.fn.isMobile,
      cutted(){
        if(this.data.media.title.length > 20){
          return this.data.media.title.substr(0,20);
        }
        return this.data.media.title;
      },
    },
    methods:{
      routeClick(m){
        if ( this.select ){
          this.addMediaToNote(m);
        }
        else{
          if(m.is_image){
            this.cp.showImage(m)
          }
        }
      },
      addMediaToNote(m){
        this.closest('appui-note-media-browser2').currentSelected = m;
        this.closest('appui-note-media-browser2').$emit('select',m)
      },
      showFileInfo(m){
        this.closest('appui-note-media-browser2').showFileInfo(m)
      },
      editMedia(m){
        this.closest('appui-note-media-browser2').editMedia(m, this.dataIdx)
      },
      removeMedia(m){
        this.closest('bbn-container').getComponent().removeMedia(m)
      },
      focusInput(){
        this.$nextTick(()=>{
          this.find('bbn-input').focus()
        })
      },
      adjustTitle(){
        if ( this.data.media.title.indexOf('.') < 0 ){
          if ( this.data.media.content.extension ){
            this.data.media.title += '.' + this.data.media.content.extension;
            return true;
          }
          else{
            //CASE INSERT
            this.validTitle = false;
            this.data.media.title = this.initialTitle;
            this.alert(bbn._('The title must contain the extension of the file'))
            return false;
          }
        }
        return false;
      },

      //change the title inline and exit from edit mode
      exitEdit(){
        this.editinline = false;
        if( this.data.media.title !== this.initialTitle ){
          let title = this.data.media.title,
              ext_title = title.substr(title.lastIndexOf('.') + 1, title.length - 1 );
          if ( ext_title === this.data.media.content.extension ){
            this.post(this.root + 'media/actions/edit_title', {
              id: this.data.media.id,
              title: this.data.media.title
            }, (d) => {
              if ( d.success ){
                this.initialTitle = this.data.media.title;
                appui.success(bbn._('Media title successfully changed!'))
              }
              else {
                appui.error(bbn._('Something went wrong while changing the media title'))
              }
            })
          }
          else {
            this.data.media.title = this.initialTitle
            this.alert(bbn._('The title must end with the same extension of the file'))
          }
        }
      }
    },
    mounted(){
      this.cp = this.closest('appui-note-media-browser2');
      this.select = this.cp.select
      this.initialTitle = this.data.media.title
      this.data.media.removedFile = false;
      this.ready = true;
    },
    watch: {
      isMobile(val){
        if(!val){
          //    this.find('bbn-context').showFloater = false;
        }
      },
      editinline(val){
        if(val){
          this.$nextTick( ()=>{
            if(this.adjustTitle()){
              this.find('bbn-input').focus();
            }
          })
        }
      }
    }
  }
})();