// Javascript Document

(() => {
  return {
    props: ['source','data'],
    data(){
      return{
        mediaIdx: false,
        //at mounted know if browser is open in selecting mode
        select: false
      };
    },
    computed :{
      btns(){
        let res = [{
          icon: 'nf nf-fa-info',
          title: 'Get more info', //bbn._('Get more info'),
          action: () => {
            this.showFileInfo(this.data.media);
          },
        }, {
          icon: 'nf nf-fa-edit',
          title: bbn._('Edit media'),
          action: () => {
            this.editMedia(this.data.media);
          }
        }, {
          icon: 'nf nf-fa-trash_o',
          title: bbn._('Delete media'),
          action: () => {
            this.removeMedia(this.data.media);
          }
        }];
        return res;
      },
    },
    methods:{
      showFileInfo(m){
        this.closest('appui-note-media-browser2').showFileInfo(m);
      },
      editMedia(m){
        this.closest('appui-note-media-browser2').editMedia(m);
      },
      removeMedia(m){
        this.closest('appui-note-media-browser2').removeMedia(m);
      }
    },
    mounted(){
      if ( this.closest('appui-note-media-browser2').select ){
        this.closest('appui-note-media-browser2').currentSelected = false;
      }
      if (this.data.media.id){
        this.mediaIdx = this.closest('appui-note-media-browser2').getIndex({id: this.data.media.id});
      }
    }
  };
})();
