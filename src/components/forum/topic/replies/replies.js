(() => {
  return {
    mixins: [
      bbn.cp.mixins.basic,
      bbn.cp.mixins.list
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