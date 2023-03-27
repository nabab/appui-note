(() => {
  return {
    mixins: [
      bbn.vue.basicComponent,
      bbn.vue.listComponent
    ],
    computed: {
      pagerVisible(){
        return this.total > this.limit;
      }
    },
    mounted(){
      this.ready = true;
    }
  }
})();