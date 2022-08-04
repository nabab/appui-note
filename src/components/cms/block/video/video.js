// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    computed: {
      youtube(){
        let reg = /^https?:\/\/w{0,3}\.?youtu\.?be(-nocookie)?(\.com)?\//gm;
        return this.source.source.search(reg) > -1;
      },
      align(){
        let style = {};
        switch (this.source.align) {
          case 'left':
            style.justifyContent = 'flex-start';
            break;
          case 'center':
            style.justifyContent = 'center';
            break;
          case 'right':
            style.justifyContent = 'flex-end';
            break;
        }
        return style;
      }, 
      width(){
        return 'min(100%, ' + this.source.style.width + ')'
      }
    }
  };
})();