// Javascript Document

(() => {
  return {
    props: ['source'],
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
      };
    },
    methods: {
      setRemovedFile(){
        this.source.removedFile = true;
        this.removedFile = true;
      },
      /** @todo Check it out */
      validation(a){
        if (a.media.file &&
            a.media.file[0] &&
            a.media.file[0].extension
           ) {
          if ((a.media.name.indexOf(a.media.file[0].extension) > -1) &&
              a.media.name.replace(a.media.file[0].extension, '').length &&
              (a.media.name.replace(a.media.file[0].extension, '') !== '.')
             ) {
            return true;
          }
        }
        else if (a.media.content &&
                 a.media.content.extension &&
                 (a.media.name.indexOf(a.media.content.extension) > -1) &&
                 a.media.name.replace(a.media.content.extension, '').length &&
                 (a.media.name.replace(a.media.content.extension, '') !== '.')
                ) {
          return true;
        }
      },
      uploadSuccess(){
        this.$nextTick(() => {
          if(this.source.media.file && this.source.media.file[0]){
            this.source.media.title = this.source.media.file[0].name;
            this.source.media.name = this.source.media.file[0].name;
          }
        });
      },
      setContent(){
        let res = [];
        if(this.source.edit){
          if ( bbn.fn.isObject(this.source.media.content)){
            this.source.media.content.name = this.source.media.name;
            res.push(this.source.media.content);
            this.content = JSON.stringify(res);
          }
        }
      },
      checkTitle(){
        if (this.source.media.title.indexOf('.') < 0) {
          let extension = this.source.edit ? this.source.media.content.extension : this.source.media.file.extension;
          if ( extension){
            this.source.media.title += '.' + this.source.media.content.extension;
          }
          else{
            //CASE INSERT
            this.validTitle = false;
            this.alert(bbn._('The title must contain the extension of the file'));
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
            this.browser.currentData[this.mediaIdx].content.name = d.media.name;
            if (d.media.is_image) {
              this.browser.currentData[this.mediaIdx].isImage = d.media.isImage;
            }
            if ( this.removedFile ){
              if(bbn.fn.isString(d.media.content)) {
                d.media.content = JSON.parse(d.media.content);
              }
              let thatMediaIdx = this.mediaIdx;
              //the block has to disappear to show the new picture uploaded
              this.browser.currentData.splice(this.mediaIdx, 1);
              setTimeout(() => {
                this.browser.currentData.splice(thatMediaIdx, 0, d.media);
                bbn.fn.log('after',thatMediaIdx, d.media, JSON.stringify(d.media));
              }, 50);
            }
            appui.success(bbn._('Media successfully updated'));
          }
          this.browser.$emit('added', d.media);
        }
        else{
          appui.error(bbn._('Something went wrong while adding the media to the media broser'));
        }
      }
    },
    mounted(){
      this.browser = this.closest('bbn-container').find('appui-note-media-browser2');
      if(this.browser && this.browser.source.length){
        this.mediaIdx =  bbn.fn.search(this.browser.source, 'id', this.source.media.id);
      }

      this.setContent();
      if (this.source.edit) {
        this.source.oldName = this.source.media.content.name;
      }

      if (this.browser && this.browser.$parent.source.id_note) {
        this.$nextTick(()=>{
          this.id_note = this.browser.$parent.source.id_note;
        });
      }
    }
  };
})();