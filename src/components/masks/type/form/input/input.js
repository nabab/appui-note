(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    data(){
      const fields = ['field', 'label', 'component', 'required'];
      return {
        fields,
        formSource: Object.fromEntries(fields.map(f => [f, this.source?.[f] || (f === 'required' ? 0 : '')])),
      }
    }
  }
})();