(() => {
  return {
    props: ['source'],
    mixins: [bbn.vue.basicComponent],
    data(){
      return {
        cp: appui.getRegistered('appuiCmsList'),
      }
    },
    methods:{
      insertNote(){
        return this.cp.insertNote();
      }
    },
    mounted(){
      alert('mouuu')
    }
  }
})()