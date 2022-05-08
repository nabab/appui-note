// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent],
    props: ['source'],
    data(){
      return {
        root: appui.plugins['appui-note'] + '/',
        users: appui.app.users
      };
    },
    computed: {
      type() {
        if (!this.source.type || !appui.options.media_types) {
          return '';
        }

        let arr = bbn.fn.isObject(appui.options.media_types) ? Object.values(appui.options.media_types) : appui.options.media_types;
        return bbn.fn.getField(arr, 'text', {id: this.source.type});
      }
    },
    methods: {
      openDetails() {
        this.getPopup({
          title: false,
          url: this.root + 'media/detail/' + this.source.id,
          width: '90%',
          height: '90%'
        }).then(() => {
          let floater = this.closest('bbn-floater');
          if (floater) {
            floater.close();
          }
        });
      },
      show_note_content(n){
        this.getPopup().open({
          title: n.title,
          content: n.content
        });
      },
      formatBytes: bbn.fn.formatBytes,
      getField: bbn.fn.getField
    }
  }
})();