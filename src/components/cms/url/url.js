// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent],
    props: {
    	source: {
        type: Object,
        required: true
      },
      prefix: {
        type: String,
        default: '',
        validator(v) {
          if (v && (bbn.fn.substr(v, -1) !== '/')) {
            throw new Error(bbn._("The prefix must finish with a slash"));
          }

          return true;
        }
      }
    },
    data(){
      return {
        urlEdited: !!this.source.id
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
          return bbn.fn.sanitize(this.prefix + st, '-').toLowerCase();
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
        if (!v || (this.makeURL(v) === this.url)) {
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