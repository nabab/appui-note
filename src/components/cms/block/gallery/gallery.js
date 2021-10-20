// Javascript Document
(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.resizerComponent, bbn.vue.mixins['appui-note-cms-block']],
    data(){
      return {
        pageSize: 1,
        currentLimit: 1,
        limits: [1],
        pageable: true,
        filterable: false,
        start: 0,
        currentPage: this.source.source && this.source.source.length ? 1 : null,
        numPages: (this.source.source || []).length,
        filteredData: this.source.source,
        total: (this.source.source || []).length,
        formData: {
          columns: this.source.columns || 3
        },
        cp: this
      }
    },
    computed: {
      columnsClass(){
        if (this.mobile) {
          if (this.source.columns > 2) {
            return 'cols-2';
          }

          return 'cols-1';
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
        bbn.vue.resizerComponent.methods.onResize.apply(this);
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
      /** @todo Seriously these arguments names??  */
      imageSuccess(a, b, res){
        if (res.success && res.image.src.length ){
          res.image.src = res.image.name;
          res.image.alt = '';
          setTimeout(() => {
            this.show = false;
            //this.source.content.push(c.image);//
            this.makeSquareImg();
            appui.success(bbn._('Image correctly uploaded'));
          }, 200);
        }
        else{
          appui.error(bbn._('An error occurred while uploading the image'));
        }
      }
    },
    watch: {
      "formData.columns"(v)  {
        this.$set(this.source, 'columns', v);
      },
      'source.columns':{
        handler(val) {
          this.makeSquareImg();
        }
      }
    },
    mounted(){
      this.makeSquareImg();
    },
  }
})();