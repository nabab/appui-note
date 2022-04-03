// Javascript Document

(() => {
  return {
    created() {
      this.closest('bbn-container').addMenu({
        text: bbn._("Settings"),
        icon: 'nf nf-fa-bars',
        url: appui.plugins['appui-note'] + 'cms/settings'
      });
    }
  };
})();