// Javascript Document

(() => {
  return {
    created() {
      appui.register('cms', this);
      this.closest('bbn-container').addMenu({
        text: bbn._("Settings"),
        icon: 'nf nf-fa-bars',
        url: appui.plugins['appui-note'] + '/cms/settings'
      });
    }
  };
})();