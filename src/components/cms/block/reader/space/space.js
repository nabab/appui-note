// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-reader']],
    methods: {
      checkAndSet(name, value) {
        if (this.ready) {
          if (this.source.style[name] === undefined) {
            let tmp = bbn.fn.camelToCss(name);
            if (this.source.style[tmp] !== undefined) {
              name = tmp;
            }
            else {
              name = bbn.fn.camelize(name);
            }
          }
          if (this.source.style[name] !== value) {
            if (this.source.style[name] !== undefined) {
              this.source.style[name] = value;
            }
            else {
              this.$set(this.source.style, name, value);
            }
          }
        }
      }
    },
    tag(){
        return this.source.tag || 'h1';
      },

     watch: {
      width(v) {
        this.width = this.currentStyle.width || '100%';
        this.checkAndSet("width", v);
      }
		}
  }
})();