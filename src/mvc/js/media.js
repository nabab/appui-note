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
          overlayName: 'title',
          selection: false
        }
      };
    },
    methods: {
      _delete(id){
        this.post(this.root + 'media/actions/delete', {id: id},
        d => {
          this.getRef('mediabrowser').refresh();
          if (d.success){
            appui.success(bbn._('Media successfully deleted'))
          }
          else{
            appui.error(bbn._('Something went wrong while deleting the media'))
          }
        }
      )
      },
      onDelete(obj){
        if (bbn.fn.isArray(obj.media)) {
          this._delete(bbn.fn.map(obj.media, m => m.id));
        }
        else {
          this.confirm(bbn._("Are you sure you want to delete this media?"), () => {
            this._delete(obj.media.id);
            }
          )
        }
      }
    }
  };
})();
