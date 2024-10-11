// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-note-cms-block']],
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
        mapped: [],
        slideshowSourceUrl: appui.plugins['appui-note'] + '/cms/data/slider_data',
        currentItems: [],
        galleryListUrl: appui.plugins['appui-note'] + '/media/data/groups/list',
        noteRoot: appui.plugins['appui-note'] + '/',
        orderFields: [{
          text: bbn._('Title'),
          value: 'versions.title'
        }, {
          text: bbn._('Pub. Date'),
          value: 'start'
        }, {
          text: bbn._('Last edit'),
          value: 'versions.creation'
        }],
        fitSource: [{
          text: bbn._('Cover'),
          value: 'cover'
        }, {
          text: bbn._('Contain'),
          value: 'contain'
        }],
        radioSource: [{
          text: bbn._('Publications'),
          value: 'publications'
        }, {
          text: bbn._('Gallery'),
          value: 'gallery'
        }, {
          text: bbn._('Features'),
          value: 'features'
        }],
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
      isPublications(){
        return this.source.mode === 'publications';
      },
      isGallery(){
        return this.source.mode === 'gallery';
      },
      isFeatures(){
        return this.source.mode === 'features';
      },
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
        this.isReady = false
        if (this.mode === 'edit'){
          let ok = false;
          let tmp = {
            id: this.source.content,
            limit: this.source.limit,
            order: this.source.order,
            mode: this.source.mode
          };
          if (this.isPublications) {
            tmp.note_type = this.source.noteType;
          }
          if (this.okMode) {
						this.$nextTick(() => {
              this.post(this.slideshowSourceUrl, tmp, d => {
                if (this.mapped.length) {
                  this.mapped.splice(0, this.mapped.length);
                }
                if (d.success && d.data) {
                  this.$nextTick(() => {
                    this.normalizeMargins(d.data);
                    bbn.fn.each(d.data, data => {
                      let tmp = bbn.fn.clone(data);
                      tmp.style = this.source.style;
                      tmp.type = 'img';
                      if (this.isGallery) {
                        tmp.content = tmp.path || '';
                      }
                      else if (this.isFeatures) {
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
        if (this.currentItems && this.currentItems.length) {
          this.currentItems.splice(0);
        }
        if (bbn.fn.isDesktopDevice() || bbn.fn.isTabletDevice()) {
          let start = 0;
          for (let i = 0; i < this.mapped.length; i += this.source.max) {
            start = i;
            const data = this.mapped.slice(start, this.source.max + start);
            this.currentItems.push({
              //mode : 'full',
              component: 'appui-note-cms-block-slider-slide',
              data
            });
          }
        }
        else if (bbn.fn.isMobileDevice()) {
          let start = 0;
          for (let i = 0; i < this.mapped.length; i += this.source.min) {
            start = i;
            const data =  this.mapped.slice(start, this.source.min + start);
            this.currentItems.push({
              //mode : 'full',
              component: 'appui-note-cms-block-slider-slide',
              data
            });
          }
        }
        if (this.source._elementor?.key) {
          let comps = appui.findAllByKey(this.source._elementor.key, '.appui-note-cms-block');
          if (!!comps) {
            bbn.fn.each(comps, c => {
              let s = c.find('appui-note-cms-block-slider');
              if (!!s) {
                s.currentItems.splice(0, s.currentItems.length, ...this.currentItems);
              }
            });
          }
        }
      },
      normalizeMargins(data){
        if (bbn.fn.isArray(data)) {
          bbn.fn.each(data, d => {
            if (d.style?.margin === undefined) {
              if (d.style === undefined) {
                this.$set(d, 'style', {});
              }
              this.$set(d.style, 'margin', this.source.margin || 0);
            }
            if (d.style?.marginMobile === undefined) {
              if (d.style === undefined) {
                this.$set(d, 'style', {});
              }
              this.$set(d.style, 'marginMobile', this.source.marginMobile || 0);
            }
          })
        }
      }
    },
    beforeMount(){
      if (!this.source.limit){
        this.$set(this.source, 'limit', 10);
      }
      if (!this.source.order){
        this.$set(this.source, 'order', 'versions.title');
      }
      if (this.source.items !== undefined) {
        this.currentItems.splice(0, this.currentItems.length, ...this.source.items);
        if (!!this.source.margin || !!this.source.marginMobile) {
          bbn.fn.each(this.source.items, it => {
            this.normalizeMargins(it.data);
          });
        }
        //this.$delete(this.source, 'items');
      }
      if (this.source.currentItems !== undefined) {
        this.$delete(this.source, 'currentItems');
      }
      if (!this.source.max){
        this.$set(this.source, 'max', 3);
      }
      if (!this.source.min){
        this.$set(this.source, 'min', 1);
      }
      if (!this.source.mode) {
        this.$set(this.source, 'mode', 'publications');
      }
      if (!!this.source.arrows && !this.source.arrowsPosition) {
        this.$set(this.source, 'arrowsPosition', 'default');
      }
      //to have the data recalculated in mode read and view the correct number of cols in mobile and desktop
      if ((this.mode === 'read')
        && !this.mapped.length
        && this.currentItems?.length
      ) {
        bbn.fn.each(this.currentItems, (v,i) => {
          this.mapped.push(...v.data)
        })
        if(this.mapped.length){
          this.adaptView()
        }
      }
    },
    mounted(){
      if (this.isFeatures) {
        this.$delete(this.source, 'noteType');
        this.okMode = true;
      }
      else if (this.isGallery) {
        this.$delete(this.source, 'noteType');
        this.okMode = true;
      }
      else if (this.isPublications) {
        this.okMode = true;
      }
      this.getSlideshowSource();
    },
    watch:{
      noteType(val){
        if (val) {
          if (this.getRef('publicationdropdown')) {
            let ddSource = this.getRef('publicationdropdown').currentData;
            let idx = bbn.fn.search(ddSource, 'data.id', val);
            if ((idx > -1) && ddSource[idx].data.id_root_alias){
              this.$set(this.source, 'id_root_alias', ddSource[idx].data.id_root_alias);
              //this.showRootAlias = true;
            }
            else{
              //this.showRootAlias = false ;
              this.$delete(this.source, 'id_root_alias');
            }
          }
        }
      },
      'source.mode'(val){
        if (val === 'features') {
          this.$delete(this.source, 'noteType');
          this.okMode = true;
        }
        else if (val === 'gallery') {
          this.$delete(this.source, 'noteType');
          this.okMode = true;
        }
        else {
          this.okMode = true;
        }
      },
      'source.min':{
        handler(val){
          this.adaptView()
        },
        deep: true
      },
      'source.max':{
        handler(val){
          this.adaptView()
        },
        deep: true
      },
      'source.limit':{
        handler(val){
          this.getSlideshowSource()
        },
        deep: true
      }
    }
  };
})();
