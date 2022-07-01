(()=>{
	return {
		props: ['data'],
		mounted(){
			
		},
		computed:{
			columns(){
				let max = this.closest('appui-note-cms-block-slider').source.max;
				let pos = this.$parent.$el.getBoundingClientRect();
				let col = (pos.width - 100) / max + 'px';
				return 'repeat(auto-fit, minmax('+ col +',1fr))';
			}
		}
	}
})()