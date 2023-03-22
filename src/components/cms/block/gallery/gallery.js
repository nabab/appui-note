// Javascript Document
(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: {
      settings: {
        type: Boolean,
        default: false
      },
      config: {
        type: Object,
        default() {
          return {
          };
        }
      },
    },
    data(){
      return {
        defaultConfig: {
          content: '',
          scrollable: 0,
          pageable: 0,
          pager: 0,
          zoomable: 0,
          resizable: 0,
          toolbar: 0,
          crop: 1,
          width: '100%',
          height: '100%',
          align: 'center',
          imageWidth: 33
        },
        itemWidth: 0,
        galleryListUrl: appui.plugins['appui-note'] + '/media/data/groups/list',
        gallerySourceUrl: appui.plugins['appui-note'] + '/media/data/groups/medias',
        sourceInfoList: [{
          text: bbn._('Title'),
          value: 'title'
        }, {
          text: bbn._('Description'),
          value: 'description'
        }]
      };
    },
    computed: {
      isConfig() {
        return this.settings;
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
      getItemWidth(){
        this.$nextTick(() => {
          let gallery = this.getRef('gallery'),
              width = this.isMobile ? 49 : this.currentSource.imageWidth;
          if (width) {
            if (gallery) {
              //the column gap to percent
              let percentGap = gallery.columnGap * 100 / gallery.lastKnownWidth ;
              this.itemWidth = gallery.lastKnownWidth / 100 * (width - percentGap);
            }
            else{
              this.itemWidth = parseInt(width);
            }
          }
          else {
            this.itemWidth = 200
          }
        })
      },
      isInConfig(fieldName) {
        return this.config[fieldName] !== undefined;
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
      }
    },
    watch: {
      'currentSource.mode'(val){
        if (val === 'link'){
          this.currentSource.zoomable = false;
        }
      },
      'currentSource.imageWidth'(val){
        if(bbn.fn.isString(val)){
          let unit = val.replace(parseInt(val), '');
          if(unit === '%'){
            this.currentSource.imageWidth = parseInt(val)
          }
          this.getItemWidth()
        }
      },
      'currentSource.source'(){
        let gallery = this.getRef('gallery');
        if (!!gallery) {
          this.$nextTick(() => {
            gallery.updateData();
          });
        }
      },
      'currentSource.resizable'(val){
        if (!!val) {
          this.currentSource.toolbar = 1;
        }
      },
      'currentSource.toolbar'(val){
        if (!val) {
          this.currentSource.resizable = 0;
        }
      },
      'currentSource.zoomable'(val){
        if (!val && !!this.currentSource.info) {
          this.currentSource.info = 0;
        }
        if(val){
          this.currentSource.mode = 'fullscreen'
        }
      },
      'currentSource.info'(val){
        if (!val && !!this.currentSource.sourceInfo) {
          this.currentSource.sourceInfo = '';
        }
      }
    },
    beforeMount(){
      if(this.currentSource.zoomable){
        this.currentSource.mode = 'fullscreen'
      }
      if(this.currentSource.imageWidth){
        this.currentSource.imageWidth = parseInt(this.currentSource.imageWidth) 
        if(this.currentSource.imageWidth > 100){
          this.currentSource.imageWidth = 33;
        }
      }

    },
    created() {
      bbn.fn.extend(this.source, {

      });
    }
  }
})();