(()=>{
	return {
		props: ['data'],
		mounted(){
			
		},
		methods: {
			imagePath(a){
				let st = '';
				if(this.mode === 'publications'){
					if(a.front_img){
						st = a.front_img.path
					}
				}
				if(this.mode === 'gallery'){
					st = a.path
				}
				if(this.mode === 'features'){
					if(a.media){
						st =  a.media.path
					}
				}
				return st;
			},
			imgStyle(a){
				let st = '',
						w = false,
						h = false;
				if(this.mode === 'publications'){
					if(a.front_img && a.front_img.dimensions){
						w = a.front_img.dimensions.w;
						h = a.front_img.dimensions.h;
					}
				}
				if(this.mode === 'gallery'){
					if(a.dimensions){
						w = a.dimensions.w;
						h = a.dimensions.h
					}
				}
				if(this.mode === 'features'){
					if(a.media && a.media.dimensions){
						w = a.media.dimensions.w;
						h = a.media.dimensions.h;
					}
				}
				if((w > h) || (w === h)){
					st = 'height: 100%;	width: auto;'
				}
				else if(h > w) {
					st = 'width: 100%;	height: auto;'
				}
				return st;
			}
			
		},
		computed:{
			max(){
				return this.closest('appui-note-cms-block-slider').source.max;
			},
			mode(){
				return this.closest('appui-note-cms-block-slider').source.mode;
			},
			columns(){
				
				let pos = this.$parent.$el.getBoundingClientRect();
				let col = (pos.width - 100) / this.max + 'px';
				return 'repeat(auto-fit, minmax('+ col +',1fr))';
			}
		},
		beforeMount(){
			//need to put empty obj in data 
			let diff =  this.max - this.data.length;
			if(diff >= 1){
				for (var i = 0; i < diff; i++ ){
					console.log(i, diff)
					this.data.push({})
				}
				
			}
		}
	}
})()