(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    data(){
      return {
        formSource: {
          field: this.source?.field || '',
          items: this.source?.items || []
        },
        isAddingItem: false,
        isEditingItem: false
      }
    },
    methods: {
      onItemSaved(d){
        if (this.isAddingItem) {
          this.formSource.items.push(d);
          this.isAddingItem = false;
        }
        else if (this.isEditingItem) {
          bbn.fn.iterate(d, (v, i) => {
            this.isEditingItem[i] = v;
          });

          this.isEditingItem = false;
        }
      }
    }
  }
})();