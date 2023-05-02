(() => {
  return {
    mixins: [
      bbn.wc.mixins.basic,
      bbn.wc.mixins.list
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