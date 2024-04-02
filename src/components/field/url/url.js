// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins.input],
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
            throw Error(bbn._("The prefix must finish with a slash"));
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
        this.emitInput(this.prefix + this.url);
      }
    },
    watch: {
      url(v) {
        bbn.fn.log(v);
        if (!this.urlEdited) {
          this.emitInput(this.prefix + v);
        }
      },
      value(v) {
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