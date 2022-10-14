// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: ['source'],
    data() {
      return {
        value: ''
      }
    },
    computed: {
      disabled(){
				return !this.source.product.stock;
			},
      type(){
        if(this.source.product.product_type){
          return bbn.fn.getField(bbn.opt.product_types,'text', 'value', this.source.product.product_type)
        }
      },
      edition(){
        if(this.source.product.id_edition){
          return bbn.fn.getField(bbn.opt.editions,'text', 'value', this.source.product.id_edition)
        }
      },
      placeholder(){
        if(this.source.product){
          return this.source.product.title
        }
        return bbn._('Pick a product')
      },
      imageSrc(){
        if(this.source.product.medias.length){
          return bbn.fn.getField(this.source.product.medias, 'path', 'id' , this.source.product.front_img)

        }
      }
    },
    methods:{
      addToCart(){
				let id_nft =  bbn.fn.getField(appui.options.product_types, "value", { code:'nft' });

				if (this.source.product_type ===  id_nft) {
					// remove comment to enable nft link to website
					//bbn.fn.link('https://nft.vivearts.com/en_US/series/photography-ofchina');
				}
				else {
					if (this.source.product.stock) {
						this.post('actions/shop/cart/add', {
							id_product: this.source.product.id,
							quantity: 1
						}, d => {
							if (d.success && d.newCart) {
								this.productAdded = true;
								this.quantity = 1;
								bbn.fn.iterate(d.newCart, (v, k) => {
									this.$root.$set(this.$root.currentCart, k, v);
								});
							}
						});
					}
				}
			},
      select(a){
        this.$set(this.source, 'product', a);
      }
    },
    beforeMount(){
			if(this.source.product && (this.source.showType === undefined)){
				this.source.showType = true;
			} 
		}
    
  };
})();