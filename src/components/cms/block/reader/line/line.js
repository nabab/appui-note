// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-reader']],
    props: [
      "source"
    ],
    computed: {
      hrStyle(){
        let r = bbn.fn.clone(this.currentStyle);
        if (r.borderWidth) {
          r.borderTopWidth = r.borderWidth || '1px';
          r.borderWidth = 0;
        }
        else {
          r.borderTopWidth = '1px';
        }

        return r;
      }
    },
    mounted() {
      bbn.fn.log("Hello");
    },
    watch: {
      source: {
        deep: true,
        handler() {
          bbn.fn.log(JSON.stringify(this.source.style));
        }
      }
    }
  }
})();
