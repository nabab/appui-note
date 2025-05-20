// Javascript Document

(() => {
  return {
    props: {
      id_parent: {
        type: String,
        default: null
      }
    },
    data() {
      return {
        data: {
          text: '',
          id_parent: this.id_parent
        }
      }
    }
  }
})();