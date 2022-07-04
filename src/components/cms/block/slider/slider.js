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
        ],
        arrowsPositions: [{
          text: bbn._('Default'),
          value: 'default'
        }, {
          text: bbn._('Top'),
          value: 'top'
        }, {
          text: bbn._('Top-Left'),
          value: 'topleft'
        }, {
          text: bbn._('Top-Right'),
          value: 'topright'
        }, {
          text: bbn._('Bottom'),
          value: 'bottom'
        }, {
          text: bbn._('Bottom-Left'),
          value: 'bottomleft'
        }, {
          text: bbn._('Bottom-Right'),
          value: 'bottomright'
        }]
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
        bbn.fn.log("YOOOPI", tmp, this.okMode);
        if (this.okMode) {
          this.post(this.slideshowSourceUrl, tmp, d => {
            bbn.fn.log("AFTER POST", d);
            if (this.mapped.length) {
              this.mapped.splice(0, this.mapped.length);
            }
            if(d.success && d.data) {
              this.$nextTick(() => {
                bbn.fn.each(d.data, data => {
                  bbn.fn.log("MAPOPING", data);
                  let tmp = bbn.fn.clone(data);
                  tmp.style = this.source.style;
                  tmp.type = 'img';
                  if (this.source.mode === 'gallery') {
                    tmp.content = tmp.path || '';
                  }
                  else if (this.source.mode === 'features') {
                      tmp.content = tmp.media ? tmp.media.url || tmp.media.path : '';
                  }
                  else {
                    tmp.content = tmp.front_img && tmp.front_img.path ? tmp.front_img.path : '';
                  }
                  tmp.info = data.title;
                  tmp.mode = 'full';
                  tmp.component = 'appui-note-cms-block-slider-slide';
                  this.mapped.push(tmp);
                });
                console.log('ADAPT VIEW')
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
            start = i,
            data = this.mapped.slice(start, this.source.max + start);


            this.source.currentItems.push({
              //mode : 'full',
              component: 'appui-note-cms-block-slider-slide',
              data: data
            });
          }
        }
        else if ( bbn.fn.isMobileDevice() ) {
          let start = 0;
          for (let i = 0; i < this.mapped.length; i += this.source.min) {
            start = i,
            data =  this.mapped.slice(start, this.source.min + start);
            this.source.currentItems.push({
              mode : 'full',
              component: 'appui-note-cms-block-slider-slide',
              data: data
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
        this.$set(this.source, 'currentItems', []);
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
      if (!!this.source.arrows && !this.source.arrowsPosition) {
        this.$set(this.source, 'arrowsPosition', 'default');
      }
    },
    mounted(){
      this.getSlideshowSource();

    }
  };
})();