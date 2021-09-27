// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, appui.mixins['appui-note-cms-reader']],
    computed: {
      items(){
        if (this.source.source && (this.source.type === 'carousel')){
          let res = [];
          let j = this.source.source.length;
          let chunk = 3;
          for (let i = 0; i < j; i += chunk) {
            let temparray = this.source.source.slice(i, i+chunk);
            res.push(temparray);
            // do whatever
          }

          return res;
        }
      },
      columnsClass(){
        if (!this.mobile) {
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
        else {
          return 'cols-2';
        }
      },
    },
    methods: {
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
    mounted() {
      this.makeSquareImg();
    },
    watch: {
      'source.columns':{
        handler(val){
          this.makeSquareImg()
        }
      }
    },
  }
})();