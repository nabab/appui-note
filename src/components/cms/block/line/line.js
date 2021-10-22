// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: {
      details: {
        type: Boolean,
        default: true
      }
    },
    computed: {
      line: {
        get(){
          return this.source.hr || null;
        },
        set(v){
          this.$set(this.source, 'hr', v);
        }
      },
      style(){
        if (!this.details) {
          return {};
        }
        let style = bbn.fn.extend(true, {}, this.source.style);
        switch (this.source.align) {
          case 'left':
            style['margin-inline-start'] = 0;
            style['margin-inline-end'] = 'auto';
            break;
          case 'center':
            style['margin-inline-start'] = 'auto';
            style['margin-inline-end'] = 'auto';
            break;
          case 'right':
            style['margin-inline-start'] = 'auto';
            style['margin-inline-end'] = 0;
            break;
        }
        return style;
      }
    }
  };
})();