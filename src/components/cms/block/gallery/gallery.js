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
        let gallery = this.$refs.gallery,
            width = this.source.imageWidth,
            int;
        if(width){
          console.log(this.$refs.gallery)
          if( gallery ){
            //the column gap to percent
            let percentGap = gallery.columnGap * 100 / gallery.width ;
            this.itemWidth = gallery.width / 100 * (width - percentGap) 
          }
          else{
            this.itemWidth = parseInt(width)
          }  
        }
        else {
          this.itemWidth = 200
        }
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
        console.log('watch',val)
        if(bbn.fn.isString(val)){
          let unit = val.replace(parseInt(val), '');
          if(unit === '%'){
            console.log('watch 2',unit)
            this.source.imageWidth = parseInt(val)
          }
          console.log('out watch')
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
      }
    },
    beforeMount(){
      if(this.source.imageWidth){
        this.source.imageWidth = parseInt(this.source.imageWidth) 
      }
      else{
        this.source.imageWidth = 150 
      }
    }
  }
})();