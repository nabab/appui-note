// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data(){
      return {
        mapped: [],
        slideshowSourceUrl: appui.plugins['appui-note'] + '/cms/data/slider_data',
        currentItems: [],
        galleryListUrl: appui.plugins['appui-note'] + '/media/data/groups/list',
        note: appui.plugins['appui-note'],
        orderFields: [{text: 'Title', value: 'versions.title'},{text: 'Pub. Date', value: 'start'}, {text: 'Last edit', value: 'versions.creation'}]
      }
    },
    computed: {
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
      }
    },
    methods: {
      getSlideshowSource(){
        if(this.source.noteType){
          this.post(this.slideshowSourceUrl, {
            'note_type' : this.source.noteType,
            'limit': this.source.limit,
            'order': this.source.order
          }, (d) => {
            if(d.success && d.data.length){
              if(this.source.currentItems && this.source.currentItems.length){
                this.source.currentItems.splice(0, this.source.currentItems.length);
              }
              this.$nextTick(() => {
                this.mapped = bbn.fn.map(d.data, data => {
                  data.type = 'img';
                  data.content = data.front_img.path;
                  data.info = data.title;
                 
                 data.mode = 'full';
                  
                  data.component = 'appui-note-cms-block-slider-slide'
                   return data;
                });
                this.adaptView()
              });
            }
            
          })
        }
      },
      adaptView(){
        if(this.source.currentItems && this.source.currentItems.length){
          this.source.currentItems.splice(0, this.source.currentItems.length);
        }
        if ( bbn.fn.isDesktopDevice() || bbn.fn.isTabletDevice()) {
          let start = 0;
          for (let i = 0; i < this.mapped.length; i += this.source.max) {
            start = i;
            this.source.currentItems.push({
              mode : 'full',
              component: 'appui-note-cms-block-slider-slide',
              data: this.mapped.slice(start, this.source.max)
            })
          }
        }
        else if ( bbn.fn.isMobileDevice() ) {
          let start = 0;
          for (let i = 0; i < this.mapped.length; i += this.source.min) {
            start = i;
            this.source.currentItems.push({
              mode : 'full',
              component: 'appui-note-cms-block-slider-slide',
              data: this.mapped.slice(start, this.source.min)
            })
          }
        }
      },
      openMediasGroups(){
        this.getPopup().load({
          title: bbn._('Medias Groups Management'),
          url: appui.plugins['appui-note'] + '/media/groups',
          width: '90%',
          height: '90%',
          onClose: () => {
            this.getRef('galleryList').updateData();
          }
        });
      },
      updateData(){
        this.getSlideshowSource()
      }
    },
    beforeMount(){
      if(!this.source.limit){
        this.source.limit = 10;
      }
      if(!this.source.order){
        this.source.order = 'versions.title'
      }
      if(!this.source.currentItems){
        this.source.currentItems = [];
      }
      if(!this.source.max){
        this.source.max = 3;
      }
      if(!this.source.min){
        this.source.min = 1;
      }
      this.updateData();
    },
    
  }
})();