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
    }
  };
})();
