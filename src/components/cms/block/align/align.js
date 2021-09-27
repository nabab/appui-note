(() => {
  return {
    data(){
      return {
        align: ''
      }
    },
    watch:{
      align(val){
        this.$parent.source.align = val
        this.$parent.$parent.$forceUpdate();
      },
    }
  };
})();
