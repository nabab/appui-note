// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent],
    data(){
      return {
        line: this.source.hr ||  null
      }
    },
    watch:{
      line(val){
        this.source.hr = val
      },
    }
  };
})();