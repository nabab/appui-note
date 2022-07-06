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
      showRootAlias(){
        if (this.source.id_root_alias ){
          return true;
        }
        return false;
      },
      noteType(){
        return this.source.noteType;
      },
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
        if(this.mode === 'edit'){
          
          let ok = false;
          let tmp = {
              limit: this.source.limit,
              order: this.source.order,
              mode: this.source.mode
            };
          if (this.sliderMode === 'publications') {
            tmp.note_type = this.source.noteType;
            if(this.source.id_option){
              tmp.id_option = this.source.id_option;
            }
          }
          else if (this.sliderMode === 'gallery') {
            tmp.id_group = this.source.id_group;
          }
          else if (this.sliderMode === 'features') {
            tmp.id_feature = this.source.id_feature;
          }
          if (this.okMode) {
						this.$nextTick(() => {
              this.post(this.slideshowSourceUrl, tmp, d => {
                if (this.mapped.length) {
                  this.mapped.splice(0, this.mapped.length);
                }
                if(d.success && d.data) {
                  this.$nextTick(() => {
                    bbn.fn.each(d.data, data => {
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
                    this.adaptView();
                  });
                }
              });
            });
          }
        }

      },
      adaptView(){
        console.log('adapt view!!!')
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
              //mode : 'full',
              component: 'appui-note-cms-block-slider-slide',
              data: data
            });
          }
        }

      },
    },
    watch:{
      noteType(val){
        if(val){
          if(this.$refs.publicationdropdown){
            let ddSource = this.$refs.publicationdropdown.currentData;
            let idx = bbn.fn.search(ddSource, 'data.id', val);
            if ((idx > -1) && ddSource[idx].data.id_root_alias){
              this.source.id_root_alias = ddSource[idx].data.id_root_alias;
              //this.showRootAlias = true;
            }
            else{
              //this.showRootAlias = false ;
            }
          }
        }
      },
      sliderMode(val){
        if(val === 'features') {
          this.$delete(this.source, 'id_group');
          this.$delete(this.source, 'noteType');
          this.okMode = true;
          this.source.mode = 'features';
        }
        else if (val === 'gallery') {
          this.$delete(this.source, 'id_feature');
          this.$delete(this.source, 'noteType');
          this.$delete(this.source, 'id_option');
          this.okMode = true;
          this.source.mode = 'gallery';
        }
        else {
          this.$delete(this.source, 'id_group');
          this.$delete(this.source, 'id_feature');
          this.okMode = true;
          this.source.mode = 'publications';
        }
      },

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
      //to have the data recalculated in mode read and view the correct number of cols in mobile and desktop
      if((this.mode === 'read') && !this.mapped.length && this.source.currentItems.length){
        bbn.fn.each(this.source.currentItems, (v,i) => {
          this.mapped.push(...v.data)
        })
        if(this.mapped.length){
          this.adaptView()
        }
      }
    },
    mounted(){
      if(this.sliderMode === 'features') {
        this.$delete(this.source, 'id_group');
        this.$delete(this.source, 'noteType');
        this.okMode = true;
        this.source.mode = 'features';
      }
      else if (this.sliderMode === 'gallery') {
        this.$delete(this.source, 'id_feature');
        this.$delete(this.source, 'noteType');
        this.okMode = true;
        this.source.mode = 'gallery';
      }
      else {
        this.$delete(this.source, 'id_group');
        this.$delete(this.source, 'id_feature');
        this.okMode = true;
        this.source.mode = 'publications';
      }
      this.getSlideshowSource();

    }
  };
})();