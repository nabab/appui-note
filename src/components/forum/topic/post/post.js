(() => {
  return {
    name: 'appui-note-forum-post',
    props: {
      source: {
        type: Object
      },
      index: {
        type: Number
      },
      lastIndex: {
        type: Number
      }
    },
    data(){
      return {
        topic: bbn.vue.closest(this, 'appui-note-forum-topic')
      }
    }
  }
})();