// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data(){
      return {
        units: [{
          text: '%',
          value: '%'
        }, {
          text: 'px',
          value: 'px'
        }, {
          text: 'em',
          value: 'em'
        }],
        currentWidth: this.source.style.width,
        currentWidthUnit: '%',
        currentHeight: this.source.style.height,
        currentHeightUnit: '%'
      }
    },
    computed: {
      youtube(){
        return this.source.src.indexOf('youtube') > -1;
      },
      style(){
        let res = !!this.currentStyle ? bbn.fn.clone(this.currentStyle) : {};
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
    },
    watch: {
      currentWidth(val){
        this.source.style.width = this.currentWidth;
      },
      currentWidthUnit(val){
        this.source.style.width = this.currentWidth + this.currentWidthUnit;
      },
      currentHeight(val){
        this.source.style.height = this.currentHeight;
      },
      currentHeightUnit(val){
        this.source.style.height = this.currentHeight + this.currentHeightUnit;
      }
    }
  };
})();