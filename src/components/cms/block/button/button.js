(()=>{
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: {
    },
    data() {
      return {
        ignoredFields: ['content', 'url'],
        defaultConfig: {
          url: '',
          content: '',
          padding: '',
          dimensions: '',
          align: 'left'
        },
      };
    },
    computed: {
      currentClasses() {
        let cc = [];
        if (this.currentSource.dimensions) {
          cc.push('bbn-' + this.currentSource.dimensions);
        }
        if (this.currentSource.hpadding) {
          cc.push('bbn-h' + this.currentSource.hpadding + 'padding-important');
        }
        if (this.currentSource.vpadding) {
          cc.push('bbn-v' + this.currentSource.vpadding + 'padding-important');
        }
        if (this.currentSource.align) {
          cc.push('bbn-' + this.currentSource.align);
        }

        return cc.join(' ');
      }
    }
  };
})();