// Javascript Document

(() => {
  return {
    methods: {
      dataURLtoFile(dataurl, filename) {
        var arr = dataurl.split(','),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]),
            n = bstr.length,
            u8arr = new Uint8Array(n);
        while(n--){
          u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, {type:mime});
      },
      saveEvent(imageData) {
        bbn.fn.log('media', this.source.media);
        //bbn.fn.log("save image data");
        bbn.fn.log("Save => ", imageData);
        let newImage = this.dataURLtoFile(imageData.imageBase64, imageData.fullName);
        bbn.fn.upload(appui.plugins["appui-note"]+"/media/actions/upload_edit", {img: newImage, id: this.source.media.id}, (res) => {
          bbn.fn.log('success', arguments);
        });
        bbn.fn.log(newImage);
      }
    }
  };
})();