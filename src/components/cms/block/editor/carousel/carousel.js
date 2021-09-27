// Javascript Document

(() => {
  return {
    computed: {
      items(){
        if (this.source.source && (this.source.type === 'carousel')){
          let res = [];
          let j = this.source.source.length;
          let chunk = 3;
          for (let i = 0; i < j; i += chunk) {
            let temparray = this.source.source.slice(i, i+chunk);
            res.push(temparray);
            // do whatever
          }

          return res;
        }
      },
      columnsClass() {
        if ( (this.source.type === 'carousel') && !this.mobile){
          if ( this.source.columns === 1 ){
            return 'cols-1'
          }
          else if ( this.source.columns === 2 ){
            return 'cols-2'
          }
          else if ( this.source.columns === 4 ){
            return 'cols-4'
          }
          return 'cols-3'
        }
        else if (this.mobile){
          return 'cols-2'
        }
      },
    }
  }
})();