(() => {
  return {
    data(){
      return {
        align: this.source.align || 'left',
      }
    },
    watch:{
      align(val){
        this.source.align = val;
      },
    }
  };
})();
