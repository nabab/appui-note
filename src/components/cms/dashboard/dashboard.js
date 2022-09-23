(() => {
  return {
    data() {
      let widgets = this.source.types_notes.map(a => {
        return {
          text: a.text,
          id: a.id,
          title: a.text,
          code: a.code,
          itemComponent: 'appui-note-widget-cms',
          url: appui.plugins['appui-note'] + '/cms/data/widget/' + a.id,
          uid: a.id,
          key: a.code,
          limit: 20,
          pageable: true
        }
      });
      widgets.unshift({
        text: bbn._("Publications"),
        id: 'pub',
        title: bbn._("Publications"),
        itemComponent: 'appui-note-widget-cms',
        options: {start: true},
        url: appui.plugins['appui-note'] + '/cms/data/widget/pub',
        uid: 'pub',
        key: 'pub',
        limit: 20,
        pageable: true
      }, {
        text: bbn._("Unpublications"),
        id: 'unpub',
        title: bbn._("Unpublications"),
        itemComponent: 'appui-note-widget-cms',
        options: {end: true},
        url: appui.plugins['appui-note'] + '/cms/data/widget/unpub',
        uid: 'unpub',
        key: 'unpub',
        limit: 20,
        pageable: true
      });

      return {
        widgets
      };
    }
  };
})();
