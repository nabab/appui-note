// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent],
    props: ['source'],
    data(){
      return {
        users: appui.app.users
      };
    },
    methods: {
      show_note_content(n){
        this.getPopup().open({
          title: n.title,
          content: n.content
        });
      },
      formatBytes: bbn.fn.formatBytes,
      getField: bbn.fn.getField,
    }
  }
})();