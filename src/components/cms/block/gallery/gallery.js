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
      defaultConfig: {
        type: Object,
        default() {
          return {
            source: '',
            scrollable: 0,
            pageable: 0,
            pager: 0,
            zoomable: 0,
            resizable: 0,
            toolbar: 0,
            crop: 1,
            style: {
              width: '100%',
              height: '100%'
            },
            align: 'center',
            imageWidth: 33
          };
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
              width = this.isMobile ? 49 : this.source.imageWidth;
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
      'source.mode'(val){
        if (val === 'link'){
          this.source.zoomable = false;
        }
      },
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
        if(val){
          this.source.mode = 'fullscreen'
        }
      },
      'source.info'(val){
        if (!val && !!this.source.sourceInfo) {
          this.source.sourceInfo = '';
        }
      }
    },
    beforeMount(){
      if(this.source.zoomable){
        this.source.mode = 'fullscreen'
      }
      if(this.source.imageWidth){
        this.source.imageWidth = parseInt(this.source.imageWidth) 
        if(this.source.imageWidth > 100){
          this.source.imageWidth = 33;
        }
      }

    },
    created() {
      bbn.fn.extend(this.source, {

      });
    }
  }
})();