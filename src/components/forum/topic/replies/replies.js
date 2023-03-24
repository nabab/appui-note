(() => {
  return {
    mixins: [
      bbn.vue.basicComponent,
      bbn.vue.listComponent
    ],
    computed: {
      pagerVisible(){
        return !!this.topic && (this.topic.source.num_replies > this.limit);
      }
    },
    mounted(){
      this.ready = true;
    }
  }
})();