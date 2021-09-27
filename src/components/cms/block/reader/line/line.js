// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, appui.mixins['appui-note-cms-reader']],
    computed: {
      style(){
        let st = '';
        if ( this.source.style ){
          if ( this.source.style.color ){
            st += 'color: ' + this.source.style.color + ';' 
          }
          if ( this.source.style.width ){
            st += 'width:' + this.source.style['width'] + ( bbn.fn.isNumber(this.source.style['width']) ? ( 'px;') : ';');
          }
          if ( this.source.style['height'] ){
            st += 'height:' + this.source.style['height'] + ( bbn.fn.isNumber(this.source.style['height']) ? ('px;' ) : ';');
          }
          if ( this.source.style['border-style'] ){
            st += 'border-style:' + this.source.style['border-style'] + ';';
          }
          if ( this.source.style['border-color'] ){
            st += 'border-color:' + this.source.style['border-color'] + ';';
          }
          if (bbn.fn.isEmpty(this.source.style) || !this.source.style['border-width'] ){
            this.source.style['border-width'] = '100%';
            st += 'border-top-width:' + this.source.style['border-width'] + ( bbn.fn.isNumber(this.source.style['border-width']) ? 'px;' : ';');
            st += 'border-bottom:0'
          }
          else if ( this.source.style['border-width'] ){
            st += 'border-width:' + this.source.style['border-width'] + ( bbn.fn.isNumber(this.source.content['border-width']) ? 'px;' : ';');
          }
        }
        if (this.source.align) {
          let margin = '';
          switch (this.source.align){
            case 'center':
              (margin = 'margin-left: auto;margin-right:auto');
              break;
            case 'left':
              this.source.type === 'video' ? (margin = 'float: left') : (margin = 'margin-left: 0');
              break;
            case 'right':
              this.source.type === 'video' ? (margin = 'float: right') : (margin = 'margin-right: 0');
              break;
          }
          st += margin;
        }

        return st;
      }
    }
  }
})();