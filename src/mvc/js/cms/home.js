// Javascript Document

(() => {
  return {
    data() {
      return {
        types_notes: appui.getRegistered('cms').source.types_notes.map(a => {
          return {
            text: a.text,
            id: a.id,
            title: a.text,
            code: a.code,
            itemComponent: 'appui-note-widget-cms',
            url: appui.plugins['appui-note'] + '/cms/data/widget/' + a.id,
            uid: a.id,
            key: a.code
          }
        })
      };
    }
  };
})();