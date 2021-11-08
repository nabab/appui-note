// Javascript Document

(() => {
  return {
    props: {
    	source: {
        type: Object,
        required: true
      }
    },
    data(){
      return {
        urlEdited: false
      }
    },
    computed: {
      url() {
        return this.makeURL(this.source.title);
      }
    },
    methods: {
      makeURL(st) {
        if (st) {
          return bbn.fn.sanitize(st, '-').toLowerCase();
        }

        return '';
      }
    },
    watch: {
      url(v) {
        if (!this.urlEdited) {
          this.source.url = v;
        }
      },
      "source.url"(v) {
        if ((v === null) || (this.makeURL(v) === this.url)) {
          if (this.urlEdited) {
            this.urlEdited = false;
            this.source.url = this.url;
          }
        }
        else if (!this.urlEdited) {
          this.urlEdited = true;
        }
      }
    }
  }
})();