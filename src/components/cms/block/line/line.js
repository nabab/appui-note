// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    computed: {
      line: {
        get(){
          return this.source.hr || null;
        },
        set(v){
          this.$set(this.source, 'hr', v);
        }
      }
    }
  };
})();