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
        type: Vue
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

        let now = new Date();
        return bbn.fn.dateSQL(now.setFullYear(now.getFullYear() + 10));
      },
      minEnd() {
        return bbn.fn.dateSQL(dayjs(this.formData.start).add(1, 'day').toDate());
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