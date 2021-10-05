// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent],
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