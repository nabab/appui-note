// Javascript Document

(() => {
  return {
    data() {
      return {
        saveHere: true,
      };
    },
    methods: {
      changeSelect() {
        this.saveHere = !this.saveHere;
      }
    }
  };
})();