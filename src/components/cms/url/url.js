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
        /*
        validator(v) {
          if (v && (bbn.fn.substr(v, -1) !== '/')) {
            throw new Error(bbn._("The prefix must finish with a slash"));
          }

          return true;
        }
        */
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
          return bbn.fn.sanitize(st, '-').toLowerCase();
        }

        return '';
      },
      updateURL() {
        this.source.url = this.prefix + this.url;
      }
    },
    watch: {
      url(v) {
        bbn.fn.log(v);
        if (!this.urlEdited) {
          this.source.url = this.prefix + v;
        }
      },
      "source.url"(v) {
        if (!v || (this.makeURL(v.substr(this.prefix.length)) === this.url)) {
          if (this.urlEdited) {
            this.urlEdited = false;
          }
        }
        else if (!this.urlEdited) {
          this.urlEdited = true;
        }
      }
    }
  }
})();