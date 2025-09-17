(() => {
  return {
    props: ['source'],
    data(){
      return {
        isDev: appui.user.isDev
      }
    },
    computed:{
      num(){
        return bbn.fn.count(this.masks.source.list, {id_type: this.source.id_type});
      }
    },
    methods: {
      editCategory(){
        this.getPopup({
          label: bbn._("Edit category of letters"),
          minWidth: 500,
          component: 'appui-note-masks-type-form',
          source: this.source,
          componentEvents: {
            success: () => {
              this.masks.$parent.getContainer().reload();
            }
          }
        });
      },
      insert(){
        this.getPopup({
          width: 800,
          height: '90%',
          component: 'appui-note-masks-form',
          source: {
            id_type: this.source.id_type,
            label: '',
            content: '',
            name: ''
          },
          label: bbn._("New letter type")
        });
      }
    }
  }
})();
