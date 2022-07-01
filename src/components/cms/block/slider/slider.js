// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data(){
      return {
        okMode: false,
        sliderMode:0,
        mapped: [],
        slideshowSourceUrl: appui.plugins['appui-note'] + '/cms/data/slider_data',
        currentItems: [],
        galleryListUrl: appui.plugins['appui-note'] + '/media/data/groups/list',
        note: appui.plugins['appui-note'],
        orderFields: [{text: 'Title', value: 'versions.title'},{text: 'Pub. Date', value: 'start'}, {text: 'Last edit', value: 'versions.creation'}],
        radioSource:[{text: 'Publications', value: 0}, {text:'Gallery', value:1}]
        
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
      getSlideshowSource(){
        let tmp = null;
        
        if(this.source.mode === 'publications'){
          tmp = {
            'note_type' : this.source.noteType,
            'limit': this.source.limit,
            'order': this.source.order,
            'mode': this.source.mode
          };
        }
        else if(this.source.mode === 'gallery'){
          tmp = {
            'id_group' : this.source.id_group,
            'limit': this.source.limit,
            'order': this.source.order,
            'mode': this.source.mode
          }
        }
        if(this.okMode){
          this.post(this.slideshowSourceUrl, tmp, (d) => {
            if(d.success && d.data.length){
              if(this.source.currentItems && this.source.currentItems.length){
                this.source.currentItems.splice(0, this.source.currentItems.length);
              }
              this.$nextTick(() => {
                this.mapped = bbn.fn.map(d.data, data => {
                  data.style = this.source.style,
                  data.type = 'img';
                  data.content = (this.source.mode === 'gallery') ? data.path : (data.front_img && data.front_img.path) ? data.front_img.path : '';
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
        else{
          this.source.currentItems = [];
        }
        if ( bbn.fn.isDesktopDevice() || bbn.fn.isTabletDevice()) {
          let start = 0;
          for (let i = 0; i < this.mapped.length; i += this.source.max) {
            start = i;
            this.source.currentItems.push({
              mode : 'full',
              component: 'appui-note-cms-block-slider-slide',
              data: this.mapped.slice(start, this.source.max + start)
            })
          }
        }
        else if ( bbn.fn.isMobileDevice() ) {
          let start = 0;
          for (let i = 0; i < this.mapped.length; i += this.source.max) {
            start = i;
            this.source.currentItems.push({
              mode : 'full',
              component: 'appui-note-cms-block-slider-slide',
              data: this.mapped.slice(start, this.source.max + start)
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
    },
    watch:{
      sliderMode(val){
        if(!val){
          this.source.mode = 'publications'
        }
        else{
          this.source.mode = 'gallery'
        }
      },
      okMode(val){
        if(val){
          if(!this.sliderMode){
            this.source.mode = 'publications'
          }
          else{
            this.source.mode = 'gallery'
          }
        }
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
        this.source.curretItems = [];
      }
      if(!this.source.max){
        this.source.max = 3;
      }
      if(!this.source.min){
        this.source.min = 1;
      }
      if(!this.source.mode){
        this.sliderMode = 0;
      }
      else if(this.source.mode === 'publications' ){
        this.sliderMode = 0;
        this.okMode = true;
      }
      else if (this.source.mode === 'gallery'){
        this.sliderMode = 1;
        this.okMode = true;
      }
    },
    
    mounted(){
      this.getSlideshowSource()
    }
    
  }
})();