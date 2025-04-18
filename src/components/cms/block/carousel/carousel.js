// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-note-cms-block']],
    props: {
      config: {
        type: Object,
      }
    },
    data(){
      return {
        defaultConfig: {
          content: '',
          autoplay: 1,
          arrows: 0,
          preview: 1,
          loop: 1,
          info: 1,
          width: '100%',
          height: '300px',
          align: 'center'
        },
        isLoading: false,
        fullScreenView: false,
        fullScreenImg: false,
        slideshowSourceUrl: appui.plugins['appui-note'] + '/media/data/groups/medias',
        currentItems: [],
        galleryListUrl: appui.plugins['appui-note'] + '/media/data/groups/list',
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
      clickItem(img){
        if(this.source.mode === 'fullscreen'){
          this.fullScreen(img)
        }
        else{
          this.closest('bbn-router').route(img.link)
        }
      },
      fullScreen(img){
        this.fullScreenView = true;
        this.fullScreenImg = img;
      },
      closeFullscreen(){
        this.fullScreenView = false;
        this.fullScreenImg = false;      },
      openMediasGroups(){
        this.getPopup().load({
          label: bbn._('Medias Groups Management'),
          url: appui.plugins['appui-note'] + '/media/groups',
          width: '90%',
          height: '90%',
          onClose: () => {
            this.getRef('galleryList').updateData();
          }
        });
      },
      updateData(){
        if (this.source.content) {
          this.isLoading = true;
          this.post(this.slideshowSourceUrl, {data: {idGroup: this.source.content}}, d => {
            if (d.success && d.data) {
              this.currentItems.splice(0, this.currentItems.length);
              this.$nextTick(() => {
                this.currentItems.push(...bbn.fn.map(d.data, data => {
                  data.type = 'img';
                  data.content = data.path;
                  data.mode = 'full';
                  data.info = data.title;
                  return data;
                }));
              });
            }
            this.isLoading = false;
          });
        }
      }
    },
    beforeMount(){
      this.updateData();
      if(!this.source.mode){
        this.source.mode = 'fullscreen'
      }
      if(this.isMobile && this.source.arrows){
        if(!this.source.arrowsPosition || this.source.arrowsPosition === 'default'){
          this.source.arrowsPosition = 'topright'
        }
      }
    },
    watch: {
      'source.content'(){
        this.updateData();
      }
    }
  }
})();