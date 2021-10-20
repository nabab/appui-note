// Javascript Document
(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data(){
      return {
        gallerySourceUrl: appui.plugins['appui-note'] + '/media/data/groups/medias'
      }
    },
    computed: {
      galleries(){
        let cp = this.closest('appui-note-cms-editor');
        if (cp && !!cp.source.mediasGroups) {
          return bbn.fn.order(bbn.fn.map(cp.source.mediasGroups, mg => {
            return {
              text: mg.text,
              value: mg.id
            };
          }), 'text', 'asc');
        }
        return [];
      },
    },
    methods: {
      openMediasGroups(){
        this.getPopup().load({
          title: bbn._('Medias Groups Management'),
          url: appui.plugins['appui-note'] + '/media/groups',
          width: '90%',
          height: '90%'
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