// Javascript Document

(() => {
  let root = appui.plugins['appui-note'] + '/';
  return {
    props: {
      source: {
        type: Object
      },
      url: {
        type: String,
        required: true
      },
      list: {
        type: Object
      }
    },
    data() {
      let now = bbn.fn.dateSQL();
      return {
        now: now,
        formData: bbn.fn.extend({}, this.source, {
          start: this.source.start || now,
          end: this.source.end || null,
        })
      };
    },
    created() {
      //this.closest()
    },
    computed: {
      minStart() {
        if (this.source.start) {
          return this.source.start;
        }

        return this.now;
      },
      maxStart() {
        if (this.formData.end) {
          return this.formData.end;
        }

        let now = new Date();
        return bbn.fn.dateSQL(now.setFullYear(now.getFullYear() + 10));
      },
      minEnd() {
        if (this.source.start) {
          return this.now > this.formData.start ? this.now : this.formData.start
        }
        return undefined;
      }
    },
    methods: {
      success(){
        if (this.list) {
          this.list.updateData();
        }
      }
    }
  }
})();