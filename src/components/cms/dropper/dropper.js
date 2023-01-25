// Javascript Document

(() => {
  return {
    props: {
      title: {
        type: String,
        required: true
      },
      type: {
        type: String,
        required: true
      },
      icon: {
        type: String,
      },
      defaultConfig: {
        type: Object,
      },
      description: {
        type: String
      }
    }
  }
})();