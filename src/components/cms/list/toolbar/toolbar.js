(() => {
  return {
    data(){
      return {
        cp: this.closest('appui-note-cms-list'),
        searchValue: ''
      }
    },
    computed: {
      categories(){
        return [{
          text: bbn._('All'),
          id: 'all'
        }, ...this.cp.types];
      }
    },
    methods:{
      insertNote(){
        if (!!this.cp) {
          return this.cp.insertNote();
        }
      }
    },
    mounted(){
      if (!!this.cp && !!this.cp.getRef('table')) {
        this.searchValue = this.cp.getRef('table').searchValue;
      }
    },
    watch: {
      searchValue(newVal){
        if (!!this.cp && !!this.cp.getRef('table')) {
          this.cp.getRef('table').searchValue = newVal;
        }
      }
    }
  }
})();
