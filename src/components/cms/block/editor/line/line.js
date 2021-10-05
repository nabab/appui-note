// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-editor']],
    data() {
      return {
        width: null,
        borderWidth: null,
        borderStyle: null,
        borderColor: null,
        borderStyles: [
          {text: "hidden", value: "hidden"},
          {text: "dotted", value: "dotted"},
          {text: "dashed", value: "dashed"},
          {text: "solid", value: "solid"},
          {text: "double", value: "double"},
          {text: "groove", value: "groove"},
          {text: "ridge", value: "ridge"}
        ]
      };
    },
    beforeMount() {
      this.width = this.currentStyle.width || '100%';
      this.borderWidth= this.currentStyle.borderWidth || 1;
      this.borderStyle = this.currentStyle.borderStyle || 'solid';
      this.borderColor = this.currentStyle.borderColor || 'black';
    },
    watch: {
      width(v) {
        this.setStyle("width", v);
      },
      borderWidth(v) {
        this.setStyle("borderWidth", v);
      },
      borderStyle(v) {
        this.setStyle("borderStyle", v);
      },
      borderColor(v) {
        this.setStyle("borderColor", v);
      },
    }
  }
})();