// Javascript Document

(() => {
  return {
    mixins: [bbn.wc.mixins.basic],
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