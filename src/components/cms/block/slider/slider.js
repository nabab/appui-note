// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data(){
      return {
        okMode: false,
        sliderMode: 'publication',
        mapped: [],
        slideshowSourceUrl: appui.plugins['appui-note'] + '/cms/data/slider_data',
        currentItems: [],
        galleryListUrl: appui.plugins['appui-note'] + '/media/data/groups/list',
        note: appui.plugins['appui-note'],
        orderFields: [
          {
            text: 'Title',
            value: 'versions.title'
          },
          {
            text: 'Pub. Date',
            value: 'start'
          },
          {
            text: 'Last edit',
            value: 'versions.creation'
          }
        ],
        radioSource:[
          {
            text: 'Publications',
            value: 'publications'
          },
          {
            text:'Gallery',
            value: 'gallery'
          },
          {
            text:'Features',
            value: 'features'
          }
        ]
      };
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
        let ok = false;
        let tmp = {
            limit: this.source.limit,
            order: this.source.order,
            mode: this.source.mode
          };
        if (this.sliderMode === 'publications') {
          tmp.note_type = this.source.noteType;
        }
        else if (this.sliderMode === 'gallery') {
          tmp.id_group = this.source.id_group;
        }
        else if (this.sliderMode === 'features') {
          tmp.id_feature = this.source.id_feature;
          bbn.fn.log("YEPI", this.sliderMode);
        }
        bbn.fn.log("YOOOPI", tmp);
        if (this.okMode) {
          this.post(this.slideshowSourceUrl, tmp, (d) => {
            if(d.success && d.data.length) {
              this.$nextTick(() => {
                this.mapped = bbn.fn.map(d.data, data => {
                  data.style = this.source.style;
                  data.type = 'img';
                  data.content = (this.source.mode === 'gallery') ? data.path : (data.front_img && data.front_img.path) ? data.front_img.path : '';
                  data.info = data.title;
                  data.mode = 'full';
                  data.component = 'appui-note-cms-block-slider-slide';
                  return data;
                });
                this.adaptView();
              });
            }
          });
        }
      },
      adaptView(){
        if (this.source.currentItems && this.source.currentItems.length){
          this.source.currentItems.splice(0, this.source.currentItems.length);
        }
        else{
          this.$set(this.source, 'currentItems', []);
        }
        if (bbn.fn.isDesktopDevice() || bbn.fn.isTabletDevice()) {

          let start = 0;
          for (let i = 0; i < this.mapped.length; i += this.source.max) {
            start = i;
            this.source.currentItems.push({
              mode : 'full',
              component: 'appui-note-cms-block-slider-slide',
              data: this.mapped.slice(start, this.source.max + start)
            });
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
            });
          }

        }
      },
    },
    watch:{
      sliderMode(val){
        if(val === 'features') {
          this.$delete(this.source, 'id_group');
          this.$delete(this.source, 'noteType');
          this.$set(this.source, 'id_feature', '');
          this.okMode = true;
          this.source.mode = 'features';
        }
        else if (val === 'gallery') {
          this.$delete(this.source, 'id_feature');
          this.$delete(this.source, 'noteType');
          this.$set(this.source, 'id_group', '');
          this.okMode = true;
          this.source.mode = 'gallery';
        }
        else {
          this.$delete(this.source, 'id_group');
          this.$delete(this.source, 'id_feature');
          this.$set(this.source, 'noteType', '');
          this.okMode = true;
          this.source.mode = 'publications';
        }
      },
      okMode(val){
        /* WTF?
        if(val){
          if(this.sliderMode === 'gallery') {
            this.source.mode = 'gallery';
          }
          if(!this.sliderMode === 'features'){
            this.source.mode = 'features';
          }
          else{
            this.source.mode = 'publications';
          }
        }
        */
      }
    },
    beforeMount(){
      if(!this.source.limit){
        this.$set(this.source, 'limit', 10);
      }
      if(!this.source.order){
        this.$set(this.source, 'order', 'versions.title');
      }
      if(!this.source.currentItems){
        this.$set(this.source, 'curretItems', []);
      }
      if(!this.source.max){
        this.$set(this.source, 'max', 3);
      }
      if(!this.source.min){
        this.$set(this.source, 'min', 1);
      }
      if(!this.source.mode){
        this.sliderMode = 'publications';
        this.$set(this.source, 'mode', this.sliderMode);
      }
      else if(this.source.mode === 'publications' ){
        this.sliderMode = 'publications';
      }
      else if (this.source.mode === 'gallery'){
        this.sliderMode = 'gallery';
      }
      else if (this.source.mode === 'features'){
        this.sliderMode = 'features';
      }
    },
    mounted(){
      this.getSlideshowSource();

    }
  };
})();