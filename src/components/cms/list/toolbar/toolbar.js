(() => {
  return {
    props: ['source'],
    mixins: [bbn.cp.mixins.basic],
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