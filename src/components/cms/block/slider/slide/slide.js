(()=>{
	return {
		props: ['data'],
		computed:{
			min(){
				return this.closest('appui-note-cms-block-slider').source.min;
			},
			max(){
				return this.closest('appui-note-cms-block-slider').source.max;
			},
			mode(){
				return this.closest('appui-note-cms-block-slider').source.mode;
			},
			columns(){
				return 'repeat(auto-fit, minmax(110px,1fr))'
			}
		},
		beforeMount(){
			//need to put empty obj in data to respect the max and min image x row
			let diff;
			if(!bbn.fn.isMobile()){
				diff = this.max - this.data.length;
			}
			else{
				diff = this.min - this.data.length;
			}
			if(diff >= 1){
				for (var i = 0; i < diff; i++ ){
					this.data.push({})
				}
				
			}

		}
	}
})()