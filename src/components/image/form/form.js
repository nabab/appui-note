// Javascript Document

(() => {
  return {
    props: {
      fileInfo: {
        type: Object,
        required: true
      },
    },
    data() {
      return {
        selected: true,
        locked: true,
        width: this.fileInfo.width,
        height: this.fileInfo.height,
        extension: this.fileInfo.extension,
        fileName: this.fileInfo.name
      };
    },
    methods: {
      changeSelect(v) {
        this.selected = !!v;
        bbn.fn.log("selected: ", this.selected);
      },
      lockSize() {
        this.locked = !this.locked;
        bbn.fn.log("locked: ", this.locked);
      },
      cancel() {
        this.$emit('close');
      },
      saveImage() {
        bbn.fn.log('emit to image-editor');
        let data = {
          name: this.fileName,
          extension: this.extension,
          width: this.width,
          height: this.height
        };
        this.$emit('sendinfo', data);
      },
      updateHeight(e) {
        if (this.locked) {
          let newWidth = Math.round((this.fileInfo.width / this.fileInfo.height) * e.target.value);
          this.width = newWidth;
        }
        this.height = e.target.value;
      },
      updateWidth(e) {
        if (this.locked) {
          let newHeight = Math.round((this.fileInfo.height / this.fileInfo.width) * e.target.value);
          this.height = newHeight;
        }
        this.width = e.target.value;
      },
      updateFileName(e) {
        this.fileName = e.target.value;
      },
      resetSize() {
        this.width = this.fileInfo.width;
        this.height = this.fileInfo.height;
      }
    },
  };
})();