// Javascript Document

(() => {
  return {
    props: {
      source: {
        type: Object,
        required: true
      }
    },
    data(){
      return this.source
    },
    created() {
      appui.register('appui-note-cms', this);
      this.closest('bbn-container').addMenu({
        text: bbn._("Settings"),
        icon: 'nf nf-fa-bars',
        url: appui.plugins['appui-note'] + '/cms/settings'
      });
    },
    beforeDestroy() {
      appui.unregister('appui-note-cms');
    }
  };
})();