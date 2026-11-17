// Javascript Document

(() => {
  return {
    props: {
      source: {
        type: [String, Array]
      },
      url: {
        type: String,
        required: true
      },
      list: {
        type: HTMLElement
      }
    },
    data() {
      let now = bbn.fn.dateSQL();
      return {
        now: now,
        formData: {
          id: this.source,
          start: now,
          end: null,
        }
      };
    },
    computed: {
      maxStart() {
        if (this.formData.end) {
          return this.formData.end;
        }

        return bbn.dt(this.now).add(10, 'year').datetime();
      },
      minEnd() {
        return bbn.dt(this.formData.start).add(1, 'day').datetime();
      }
    },
    methods: {
      success(d){
        if (d.success) {
          appui.success(d.message || '');
        }
        else {
          appui.error();
        }
        if (this.list) {
          if (bbn.fn.isArray(this.source)) {
            this.list.currentSelected.splice(0);
          }
          this.list.updateData();
        }
      }
    }
  }
})();