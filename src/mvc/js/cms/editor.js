// Javascript Document

(() => {
  return {
    data(){
      return {
        oData: JSON.stringify(this.source),
        ready: false
      };
    },
    computed: {
      isChanged(){
        return JSON.stringify(this.source) !== this.oData;
      },
      contextSource(){
        let ed = this.getRef('editor');
        let newBlock = {
          type: 'text',
          content: ''
        };
        let res = [{
          text: bbn._("Add a block at the start"),
          action: () => {
            this.source.items.splice(0, 0, newBlock);
          }
        }];
        if (this.source.items.length > 0) {
          res.push({
            text: bbn._("Add a block at the end"),
            action: () => {
              this.source.items.push(newBlock);
            }
          });
        }
        if (ed) {
          if (ed.currentEdited > 1) {
            res.push({
              text: bbn._("Add a block before the selected block"),
              action: () => {
                this.source.items.splice(ed.currentEdited, 0, newBlock);
              }
            });
          }
          if (ed.currentEdited < (this.source.items.length -2)) {
            res.push({
              text: bbn._("Add a block after the selected block"),
              action: () => {
                this.source.items.splice(ed.currentEdited + 1, 0, newBlock);
              }
            });
          }
        }
        return res;
      }
    },
    methods: {
      save(){

      }
    }
  }
})();