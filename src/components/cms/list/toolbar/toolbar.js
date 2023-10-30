(() => {
  return {
    data(){
      let cp = this.closest('appui-note-cms-list');
      let actions = [];
      if (cp.publishUrl?.length) {
        actions.push({
          text: bbn._('Publish'),
          action: this.publishGroup,
          icon: 'nf nf-fa-chain'
        });
      }

      if (cp.unpublishUrl?.length) {
        actions.push({
          text: bbn._('Unpublish'),
          action: this.unpublishGroup,
          icon: 'nf nf-fa-chain_broken'
        });
      }

      if (cp.moveUrl?.length) {
        actions.push({
          text: bbn._('Move to another category'),
          action: this.moveGroup,
          icon: 'nf nf-md-folder_move bbn-lg'
        });
      }

      if (cp.deleteUrl?.length) {
        actions.push({
          text: bbn._('Delete'),
          action: this.deleteGroup,
          icon: 'nf nf-fa-trash_o'
        });
      }

      return {
        cp: cp,
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
        }],
        groupActionsDisabled: true,
        groupActions: actions
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
      },
      publishGroup(){
        if (!!this.cp) {
          let table = this.cp.getRef('table');
          if (!!table && table.currentSelected.length) {
            this.cp.publishNote(table.currentSelected);
          }
        }
      },
      unpublishGroup(){
        if (!!this.cp) {
          let table = this.cp.getRef('table');
          if (!!table && table.currentSelected.length) {
            this.cp.unpublishNote(table.currentSelected);
          }
        }
      },
      moveGroup(){
        if (!!this.cp) {
          let table = this.cp.getRef('table');
          if (!!table && table.currentSelected.length) {
            this.cp.moveNote(table.currentSelected);
          }
        }
      },
      deleteGroup(){
        if (!!this.cp) {
          let table = this.cp.getRef('table');
          if (!!table && table.currentSelected.length) {
            this.cp.deleteNote(table.currentSelected);
          }
        }
      }
    },
    mounted(){
      if (!!this.cp && !!this.cp.getRef('table')) {
        let table = this.cp.getRef('table');
        this.searchValue = table.searchValue;
        this.tableWatch = table.$watch('currentSelected', newVal => {
          this.groupActionsDisabled = !newVal.length;
        });
      }
    },
    beforeDestroy(){
      this.tableWatch();
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
