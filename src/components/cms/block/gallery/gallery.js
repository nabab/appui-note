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
        default(){
          return {};
        }
      }
    },
    data(){
      return {
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
      getItemWidth(){
        this.$nextTick(() => {
          let gallery = this.getRef('gallery'),
              width = this.isMobile ? 45 : this.source.imageWidth;
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
      'source.imageWidth'(val){
        if(bbn.fn.isString(val)){
          let unit = val.replace(parseInt(val), '');
          if(unit === '%'){
            this.source.imageWidth = parseInt(val)
          }
          this.getItemWidth()
        }
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
      },
      'source.info'(val){
        if (!val && !!this.source.sourceInfo) {
          this.source.sourceInfo = '';
        }
      }
    },
    beforeMount(){

      if(this.source.imageWidth){
        this.source.imageWidth = parseInt(this.source.imageWidth) 
        if(this.source.imageWidth > 100){
          this.source.imageWidth = 33;
        }
      }

    }
  }
})();