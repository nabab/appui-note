// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: {
      config: {
        type: Object
      },
    },
    data(){
      return {
        defaultConfig: {
          content: "",
          autoplay: 1,
          arrows: 0,
          preview: 1,
          loop: 1,
          info: 1,
          width: '100%',
          height: '100%',
          align: 'center',
          margin: '0px',
          marginMobile: '0px'
        },
        isReady: true,
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
        fitSource:[
          {
            text: 'Cover',
            value: 'cover'
          },
          {
            text:'Contain',
            value: 'contain'
          },
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
        if (this.currentSource.id_root_alias ){
          return true;
        }
        return false;
      },
      noteType(){
        return this.currentSource.noteType;
      },
      align(){
        let style = {};
        switch (this.currentSource.align) {
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
        this.isReady = false
        console.log('getslide',this.isReady)
        if(this.mode === 'edit'){

          let ok = false;
          let tmp = {
            limit: this.currentSource.limit,
            order: this.currentSource.order,
            mode: this.currentSource.mode
          };
          if (this.sliderMode === 'publications') {
            tmp.note_type = this.currentSource.noteType;
            if(this.currentSource.id_option){
              tmp.id_option = this.currentSource.id_option;
            }
          }
          else if (this.sliderMode === 'gallery') {
            tmp.id_group = this.currentSource.id_group;
          }
          else if (this.sliderMode === 'features') {
            tmp.content = this.currentSource.content;
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
                      tmp.style = this.currentSource.style;
                      tmp.type = 'img';
                      if (this.currentSource.mode === 'gallery') {
                        tmp.content = tmp.path || '';
                      }
                      else if (this.currentSource.mode === 'features') {
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
        if (this.currentSource.currentItems && this.currentSource.currentItems.length){
          this.currentSource.currentItems.splice(0, this.currentSource.currentItems.length);
        }
        else{
          this.$set(this.currentSource, 'currentItems', []);
        }
        if (bbn.fn.isDesktopDevice() || bbn.fn.isTabletDevice()) {
          let start = 0;
          for (let i = 0; i < this.mapped.length; i += this.currentSource.max) {
            start = i,
              data = this.mapped.slice(start, this.currentSource.max + start);
            this.currentSource.currentItems.push({
              //mode : 'full',
              component: 'appui-note-cms-block-slider-slide',
              data: data
            });
          }
        }

        else if ( bbn.fn.isMobileDevice() ) {

          let start = 0;
          for (let i = 0; i < this.mapped.length; i += this.currentSource.min) {
            start = i,
              data =  this.mapped.slice(start, this.currentSource.min + start);
            this.currentSource.currentItems.push({
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
              this.currentSource.id_root_alias = ddSource[idx].data.id_root_alias;
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
          this.$delete(this.currentSource, 'id_group');
          this.$delete(this.currentSource, 'noteType');
          this.okMode = true;
          this.currentSource.mode = 'features';
        }
        else if (val === 'gallery') {
          this.$delete(this.currentSource, 'content');
          this.$delete(this.currentSource, 'noteType');
          this.$delete(this.currentSource, 'id_option');
          this.okMode = true;
          this.currentSource.mode = 'gallery';
        }
        else {
          this.$delete(this.currentSource, 'id_group');
          this.$delete(this.currentSource, 'content');
          this.okMode = true;
          this.currentSource.mode = 'publications';
        }
      },
      'currentSource.min':{
        handler(val){
          this.adaptView()
        },
        deep: true
      },
      'currentSource.max':{
        handler(val){
          this.adaptView()
        },
        deep: true
      },
      'currentSource.limit':{
        handler(val){
          this.getSlideshowSource()
        },
        deep: true
      }
    },
    beforeMount(){
      if(!this.currentSource.limit){
        this.$set(this.currentSource, 'limit', 10);
      }
      if(!this.currentSource.order){
        this.$set(this.currentSource, 'order', 'versions.title');
      }
      if(!this.currentSource.currentItems){
        this.$set(this.currentSource, 'currentItems', []);
      }
      if(!this.currentSource.max){
        this.$set(this.currentSource, 'max', 3);
      }
      if(!this.currentSource.min){
        this.$set(this.currentSource, 'min', 1);
      }
      if(!this.currentSource.mode){
        this.sliderMode = 'publications';
        this.$set(this.currentSource, 'mode', this.sliderMode);
      }
      else if(this.currentSource.mode === 'publications' ){
        this.sliderMode = 'publications';
      }
      else if (this.currentSource.mode === 'gallery'){
        this.sliderMode = 'gallery';
      }
      else if (this.currentSource.mode === 'features'){
        this.sliderMode = 'features';
      }
      if (!!this.currentSource.arrows && !this.currentSource.arrowsPosition) {
        this.$set(this.currentSource, 'arrowsPosition', 'default');
      }
      //to have the data recalculated in mode read and view the correct number of cols in mobile and desktop
      if((this.mode === 'read') && !this.mapped.length && this.currentSource.currentItems.length){
        bbn.fn.each(this.currentSource.currentItems, (v,i) => {
          this.mapped.push(...v.data)
        })
        if(this.mapped.length){
          this.adaptView()
        }
      }
    },
    mounted(){
      if(this.sliderMode === 'features') {
        this.$delete(this.currentSource, 'id_group');
        this.$delete(this.currentSource, 'noteType');
        this.okMode = true;
        this.currentSource.mode = 'features';
      }
      else if (this.sliderMode === 'gallery') {
        this.$delete(this.currentSource, 'content');
        this.$delete(this.currentSource, 'noteType');
        this.okMode = true;
        this.currentSource.mode = 'gallery';
      }
      else {
        this.$delete(this.currentSource, 'id_group');
        this.$delete(this.currentSource, 'content');
        this.okMode = true;
        this.currentSource.mode = 'publications';
      }
      this.getSlideshowSource();

    }
  };
})();