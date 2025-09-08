(() => {
  return {
    props: ['source'],
    computed:{
      num(){
        return bbn.fn.count(this.masks.source.categories, {id_type: this.source.id_type});
      }
    },
    methods: {
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
