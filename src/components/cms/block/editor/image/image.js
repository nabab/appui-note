// Javascript Document

(() => {
  return {
    beforeMount(){
      if (this.source.content) {
        let extension = this.source.content.substr(this.source.content.lastIndexOf('.'), this.source.content.length)
        //take the correct size
        this.image.push({
          "name": this.source.content,
          "size":574906,
          "extension": extension
        });
      }
    }
  }
})();