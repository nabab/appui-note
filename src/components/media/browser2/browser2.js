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
          component: this.$options.components['form'],
          height: '400px',
          width: '400px',
          source: {
            media: m,
            edit: true,
            removedFile: false,
            oldName: ''
          },
        })
      },
      addMedia(){
        this.getPopup().open({
          title: bbn._('Add new media'),
          component: this.$options.components['form'],
          height: '400px',
          width: '400px',
          source: {
            media: {
              title: '',
              file: [],
              name: ''
        		}
          }
        })
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
          component: this.$options.components['info'],
          width: 400,
        })
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
        bbn.fn.error('watch')
        bbn.fn.happy(a.title.toLowerCase().indexOf(val.toLowerCase()))
        this.medias = bbn.fn.filter(this.currentData, (a) => {
         
          return a.title.toLowerCase().indexOf(val.toLowerCase()) > -1
        })
      }
    },
    components: {
      form: {
        props: ['source'],
        template: `
<div class="bbn-padded">
	<bbn-form :validation="validation" :source="source" :data="{ref:ref, id_note:id_note}" :action="root + (source.edit ? 'media/actions/edit' : 'media/actions/save')" @success="success">
		<div class="bbn-grid-fields">
			<div v-if="browser.single">Title: </div>
			<bbn-input v-model="source.media.title" @blur="checkTitle"
                 v-if="browser.single" 
                 :disabled="source.edit ? false : (!source.media.file.length ?true : false )"
			></bbn-input>

			<div v-if="browser.single">Filename: </div>
			<bbn-input v-if="browser.single"
                 v-model="source.media.name"
								 :disabled="source.edit ? false : (!source.media.file.length ?true : false )"
			></bbn-input>

			<div>Media: </div>
			<div>
				<bbn-upload v-if="source.edit"
										:json="true"
										v-model="content"
										:paste="true"
										:multiple="false"
										:save-url="root + 'media/actions/upload_save/' + ref"
										@remove="setRemovedFile"
										:remove-url="root + 'media/actions/delete_file/'+ source.media.id"
				></bbn-upload>
				<bbn-upload v-model="source.media.file"
										v-else
									  @success="uploadSuccess"
										:paste="true"
										:multi="false"
										:save-url="root + 'media/actions/upload_save/' + ref"
				></bbn-upload></div>
		</div>
	</bbn-form>
</div>`,
        data(){
          return {
            browser: {},
            root: appui.plugins['appui-note'] + '/',
            ref: (new Date()).getTime(),
            validTitle: true,
            content: [],
            //the idx of the media in medias of the container
            removedFile: false,
            mediaIdx:false,
            id_note:false
          }
        },
			  methods: {
          setRemovedFile(){
            this.source.removedFile = true
            this.removedFile = true
          },
          /** @todo Check it out */
          validation(a){
            if (a.media.file
                && a.media.file[0]
                && a.media.file[0].extension
            ) {
            	if ((a.media.name.indexOf(a.media.file[0].extension) > -1)
                  && a.media.name.replace(a.media.file[0].extension, '').length
                  && (a.media.name.replace(a.media.file[0].extension, '') !== '.')
              ) {
                return true;
              }
            }
            else if (a.media.content
                     && a.media.content.extension
                     && (a.media.name.indexOf(a.media.content.extension) > -1)
                     && a.media.name.replace(a.media.content.extension, '').length
                     && (a.media.name.replace(a.media.content.extension, '') !== '.')
            ) {
              return true;
            }
            /*else{
              this.alert(bbn._("The extension in the title or in the filename doesn't match the extension of the file inserted!"))
              return false;
            }*/
          },
          uploadSuccess(){
            this.$nextTick(() => {
              if(this.source.media.file && this.source.media.file[0]){
                this.source.media.title = this.source.media.file[0].name
                this.source.media.name = this.source.media.file[0].name
              }
            })
          },
          setContent(){
            let res = [];
            if(this.source.edit){
              if ( bbn.fn.isObject(this.source.media.content)){
                this.source.media.content.name = this.source.media.name;
                res.push(this.source.media.content)
                this.content = JSON.stringify(res)
              }
            }
          },
         	checkTitle(){
            if ( this.source.media.title.indexOf('.') < 0 ){
              let extension = this.source.edit ? this.source.media.content.extension : this.source.media.file.extension
              if ( extension){
                this.source.media.title += '.' + this.source.media.content.extension
              }
              else{
                //CASE INSERT
                this.validTitle = false;
                this.alert(bbn._('The title must contain the extension of the file'))
              }
            }
          },
          success(d){
            if(d.success && d.media){
              if ( !this.source.edit ){
                this.browser.source.push(d.media);
                // this.browser.add does not exist!
                //this.browser.add(d.media);
                appui.success(bbn._('Media successfully added to media browser'));
              }
              else{
                this.browser.currentData[this.mediaIdx].content['name'] = d.media.name
                if (d.media.is_image ){
                  this.browser.currentData[this.mediaIdx].isImage = d.media.isImage
                }
                if ( this.removedFile ){
                  if(bbn.fn.isString(d.media.content)){
                    d.media.content = JSON.parse(d.media.content)
                  }
                  let thatMediaIdx = this.mediaIdx
                  //the block has to disappear to show the new picture uploaded
                  this.browser.currentData.splice(this.mediaIdx, 1);
                  setTimeout(() => {
                    this.browser.currentData.splice(thatMediaIdx, 0, d.media);
                    bbn.fn.log('after',thatMediaIdx, d.media, JSON.stringify(d.media))
                  }, 50);
                }
                appui.success(bbn._('Media successfully updated'));
              }
              this.browser.$emit('added', d.media);
            }
            else{
              appui.error(bbn._('Something went wrong while adding the media to the media broser'))
            }
          }
        },
        mounted(){
          this.browser = this.closest('bbn-container').find('appui-note-media-browser2')
          if(this.browser && this.browser.source.length){
            this.mediaIdx =  bbn.fn.search(this.browser.source, 'id', this.source.media.id);
          }
          
          this.setContent();
          this.source.edit ? (this.source.oldName = this.source.media.content.name) : '';
          if(this.browser && this.browser.$parent.source.id_note){
            this.$nextTick(()=>{
              this.id_note = this.browser.$parent.source.id_note;
            })
          }
        },
        watch: {
          /*content(val, oldVal){
            if(val){
              let tmp = JSON.parse(val)
              if(tmp[0]){
                this.source.media.content = tmp[0];
              }
            }
          }*/
        }
      },
      'info': {
          template:
`
<div>
	<div class="bbn-grid-fields bbn-padded">
		<div>Title:</div>
		<div v-text="source.title"></div>
		<div>Filename:</div>
		<div v-text="source.name"></div>
		<div>Type:</div>
		<div v-text="source.type"></div>
		<div>User:</div>
		<div v-text="getField(users, 'text', {value: source.id_user})"></div>
		<div>Size:</div>
    <div v-text="formatBytes(source.content.size)"></div>
    <div>Extension:</div>
    <div v-text="source.content.extension"></div>
    <div class="bbn-grid-full bbn-bordered bbn-radius bbn-spadded bbn-vmargin" v-for="n in source.notes">
      <div class="bbn-grid-fields">
        <div>Note title:</div>
        <div v-text="n.title"></div>
        <div>Creation:</div>
        <div v-text="n.creation"></div>
        <div>Version:</div>
        <div v-text="n.version"></div>
				<div>Published:</div>
        <div v-text="n.is_published ? _('Yes') : _('No') "></div>
        <div>Content:</div>
        <i class="nf nf-mdi-comment_text bbn-medium bbn-p" title="Note content" @click="show_note_content(n)"></i>
      </div>
    </div>
  </div>
</div>
`,
        props: ['source'],
        data(){
          return {
            users: appui.app.users
          }
        },
        methods: {
          show_note_content(n){
            this.getPopup().open({
              title: n.title,
              content: n.content
            })
          },
          formatBytes: bbn.fn.formatBytes,
          getField: bbn.fn.getField,
        }
      },
      'block': {
        template: '#appui-note-media-browser-block',
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
      },
      'list': {
        template: `
<bbn-list :source="btns"
           class="media-floating-list bbn-bordered"
           >
 </bbn-list>
`,
        props: ['source','data'],
        data(){
          return{
            mediaIdx: false,
            //at mounted know if browser is open in selecting mode
            select: false
          }
        },
        computed :{
          btns(){
            let res = [{
             icon: 'nf nf-fa-info',
             title: 'Get more info', //bbn._('Get more info'),
             action: () => {
               this.showFileInfo(this.data.media)
             	},
            }, {
             icon: 'nf nf-fa-edit',
             title: bbn._('Edit media'),
             action: () => {
             	 this.editMedia(this.data.media)
             }
            }, {
             icon: 'nf nf-fa-trash_o',
             title: bbn._('Delete media'),
             action: () => {
             	 this.removeMedia(this.data.media)
             }
            }];
            return res;
          },
        },
       	methods:{
          showFileInfo(m){
            this.closest('appui-note-media-browser2').showFileInfo(m)
          },
          editMedia(m){
            this.closest('appui-note-media-browser2').editMedia(m)
          },
          removeMedia(m){
            this.closest('appui-note-media-browser2').removeMedia(m)
          }
        },
        mounted(){
          if ( this.closest('appui-note-media-browser2').select ){
            this.closest('appui-note-media-browser2').currentSelected = false
          }
          if (this.data.media.id){
            this.mediaIdx = this.closest('appui-note-media-browser2').getIndex({id: this.data.media.id})
          }
        }
      }
    }
  }
})();