// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, appui.mixins['appui-note-cms-editor']],
    computed: {
      youtube(){
        return this.source.src.indexOf('youtube') > -1;
      },
      style(){
        let res = bbn.fn.clone(this.currentStyle);
        if (this.source.align) {
          let margin = '';
          switch (this.source.align){
            case 'center':
              res.marginLeft = 'auto';
              res.marginRight = 'auto';
              break;
            case 'left':
              res.float = 'left';
              res.marginLeft = '0';
              break;
            case 'right':
              res.float = 'right';
              res.marginRight = 'auto';
              break;
          }
        }

        return res;
      }
    }
  };
})();