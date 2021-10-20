(() => {
  return {
    methods: {
      next(){
        if ( this.$parent.currentCarouselIdx < (this.$parent.carouselSource.length -1) ){
          this.$parent.currentCarouselIdx ++
        }
      },
      prev(){
        if ( this.$parent.currentCarouselIdx > 0 ){
          this.$parent.currentCarouselIdx --
        }
      }
    }

  };
})(); 
