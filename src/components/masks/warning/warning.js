(() => {
  return {
    data() {
      return {
        doNotShowAgain: this.source.doNotShowAgainValue || false
      }
    },
    methods: {
      close() {
        if (this.doNotShowAgain) {
          this.masks.setStorage(true);
        }

        this.closest('bbn-floater').close(true)
      }
    }
  }
})();