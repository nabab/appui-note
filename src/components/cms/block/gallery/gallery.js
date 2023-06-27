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
          imageAlign: 'center',
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
      }
    },
    methods: {
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
      },
      checkImageWidth(val){
        if (this.isMobile) {
          this.itemWidth = 49;
          return;
        }
        else if (val) {
          let value = parseInt(val);
          if (bbn.fn.isString(val)) {
            let unit = val.replace(value, '');
            if (unit === '%') {
              this.source.imageWidth = value > 100 ? 100 : value;
            }
          }
          else if (bbn.fn.isNumber(val)) {
            this.source.imageWidth = value;
          }
        }
        else {
          this.source.imageWidth = 33;
        }
        this.itemWidth = this.source.imageWidth;
      }
    },
    beforeMount(){
      if(this.source.zoomable){
        this.source.mode = 'fullscreen'
      }
      if (this.source.imageWidth) {
        this.checkImageWidth(this.source.imageWidth);
      }

    },
    watch: {
      'source.mode'(val){
        if (val === 'link'){
          this.source.zoomable = false;
        }
      },
      'source.imageWidth'(val){
        this.checkImageWidth(val);
      },
      'source.source'(){
        let gallery = this.getRef('gallery');
        if (!!gallery) {
          this.$nextTick(() => {
            gallery.updateData();
          });
        }
      },
      'source.resizable'(val){
        if (!!val) {
          this.source.toolbar = 1;
        }
      },
      'source.toolbar'(val){
        if (!val) {
          this.source.resizable = 0;
        }
      },
      'source.zoomable'(val){
        if (!val && !!this.source.info) {
          this.source.info = 0;
        }
        if(val){
          this.source.mode = 'fullscreen'
        }
      },
      'source.info'(val){
        if (!val && !!this.source.sourceInfo) {
          this.source.sourceInfo = '';
        }
      }
    }
  }
})();