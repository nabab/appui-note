(() => {
  return {
    data(){
      return {
        cp: this.closest('appui-note-cms-list'),
        searchValue: '',
        currentStatus: 'all',
        statusList: [{
          text: bbn._('All'),
          value: 'all'
        }, {
          text: bbn._('Published'),
          value: 'published'
        }, {
          text: bbn._('Unpublished'),
          value: 'unpublished'
        }]
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
      },
      currentStatus(newVal){
        if (!!this.cp && !!this.cp.getRef('table')) {
          switch (newVal) {
            case 'all':
              this.cp.unsetStatusFilter();
              break;
            case 'published':
              this.cp.setPublishedFilter();
              break;
            case 'unpublished':
              this.cp.setUnpublishedFilter();
              break;
          }
        }
      }
    }
  }
})();
