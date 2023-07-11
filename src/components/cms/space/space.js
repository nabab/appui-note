// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    data(){
      return {
        space: this.source.hr ||  null
      }
    },
    watch:{
      space(val){
        this.source.hr = val
      },
    }
  };
})();