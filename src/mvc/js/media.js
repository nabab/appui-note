(() => {
  return {
    data(){
      let root = appui.plugins['appui-note'] + '/';
      return {
        root: root,
        browserOptions: {
          download: root + 'media/actions/download',
          upload : root + 'media/actions/save',
          remove: root + 'media/actions/remove',
          edit: root + 'media/actions/edit',
          detail: root + 'media/detail/',
          limit: 50,
          pathName: 'path',
          overlayName: 'title'
        }
      };
    },
    methods: {
      onDelete(obj){
        this.confirm(bbn._("Are you sure you want to delete this media?"), () => {
            this.post(this.root + 'media/actions/delete', {id: obj.media.id},
              d => {
                if (d.success){
                  this.getRef('mediabrowser').refresh();
                  appui.success(bbn._('Media successfully deleted'))
                }
                else{
                  appui.error(bbn._('Something went wrong while deleting the media'))
                }
              }
            )
          }
        )
      }
    }
  };
})();
