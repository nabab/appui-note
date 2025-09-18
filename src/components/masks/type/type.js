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
        if (this.source.id_type) {
          const cat = bbn.fn.getRow(this.masks.source.categories, {id: this.source.id_type});
          if (cat) {
            this.getPopup({
              label: bbn._("Edit category of letters"),
              minWidth: 500,
              component: 'appui-note-masks-type-form',
              source: cat,
              componentEvents: {
                success: () => {
                  this.masks.$parent.getContainer().reload();
                }
              }
            });
          }
        }
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
