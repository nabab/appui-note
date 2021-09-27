// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.resizerComponent, appui.mixins['appui-note-cms-reader']],
    computed: {
      columnsClass(){
        if (this.mobile) {
          if (this.source.columns !== 2) {
            return 'cols-2';
          }
          else{
            return 'cols-1';
          }
        }
        else {
          if ( this.source.columns === 1 ){
            return 'cols-1';
          }
          else if ( this.source.columns === 2 ){
            return 'cols-2';
          }
          else if ( this.source.columns === 4 ){
            return 'cols-4';
          }
          return 'cols-3';
        }
      },
    },
    methods: {
      onResize(){
        bbn.vue.resizerComnponent.methods.onResize.apply(this);
        this.makeSquareImg();
      },
      makeSquareImg(){
        if ( !this.source.noSquare ){
          //creates square container for the a
          var items = this.$el.querySelectorAll('a'),
              images = this.$el.querySelectorAll('img');
          this.show = false;
          if (this.source.columns === 1){
            for (let i in items ){
              if ( images[i].tagName === 'IMG' ){
                this.$nextTick(()=>{
                  images[i].style.height = 'auto';
                  images[i].style.width = '100%';
                })
              }
            }
          }
          else {
            for (let i in images ){
              if ( images[i].tagName === 'IMG' ){
                this.$nextTick(()=>{
                  images[i].style.height = items[i].offsetWidth + 'px';
                })
              }
            }

          }
          this.show = true;
        }
      },
    },
    mounted(){
      this.onResize();
      this.makeSquareImg();
    },
    watch: {
      'source.columns':{
        handler(val) {
          this.makeSquareImg();
        }
      }
    }
  };
})();
