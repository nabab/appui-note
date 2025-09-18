(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    data(){
      const fields = ['field', 'label', 'component', 'componentOptions', 'required'];
      return {
        fields,
        formSource: Object.fromEntries(fields.map(f => {
          let val = this.source?.[f];
          if (val === undefined) {
            switch (f) {
              case 'required':
                val = 0;
                break;
              case 'componentOptions':
                val = {};
              default:
                val = '';
                break;
            }
          }

          return [f, val];
        })),
      }
    }
  }
})();