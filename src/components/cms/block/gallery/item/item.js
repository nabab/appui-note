(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: ['source', 'index'],
    methods:{
      //IMPORTANT TO RENDER CHINESE CHARACTERS
      decodeURIComponent(st){
        return this.$parent.decodeURIComponent(st);
      },
      escape(st){
        return this.$parent.escape(st);
      },
      selectImg(){
        return this.closest('appui-note-cms-block').selectImg(this.source.href)
      }
    },
    computed: {
      path(){
        return this.$parent.path
      },
      linkURL(){
        return this.$parent.linkURL
      },
      type(){
        return this.$parent.source.type
      }
    },
    mounted(){
      bbn.fn.happy(this.source.price)
    }
  }
})();