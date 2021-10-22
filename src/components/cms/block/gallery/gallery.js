// Javascript Document
(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data(){
      return {
        galleryListUrl: appui.plugins['appui-note'] + '/media/data/groups/list',
        gallerySourceUrl: appui.plugins['appui-note'] + '/media/data/groups/medias'
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
    }
  }
})();