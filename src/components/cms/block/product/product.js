// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: ['source'],
    data() {
      return {
        root: appui.plugins['appui-note'] + '/',
        value: '',
        isOk: false
      }
    },
    computed: {
      placeholder(){
        if(this.isOk && this.currentSource.product.title){
          return this.currentSource.product.title
        }
        return ''
      },
      showProduct(){
        if(this.isOk && this.currentSource.product && this.currentSource.product.ok){
          return true
        }
        return false
      },
      disabled(){
        if(this.isOk && !this.currentSource.product.stock){
          return true;
        }
        else {
          return false
        }
			},
      type(){
        if(this.currentSource.product.product_type && this.isOk){
          return bbn.fn.getField(bbn.opt.product_types,'text', 'value', this.currentSource.product.product_type)
        }
      },
      edition(){
        if(this.currentSource.product.id_edition && this.isOk){
          return bbn.fn.getField(bbn.opt.editions,'text', 'value', this.currentSource.product.id_edition)
        }
      },
      
      imageSrc(){
        if(this.currentSource.product.medias.length && this.isOk){
          return bbn.fn.getField(this.currentSource.product.medias, 'path', 'id' , this.currentSource.product.front_img)

        }
      }
    },
    methods:{

      addToCart(){
				let id_nft =  bbn.fn.getField(appui.options.product_types, "value", { code:'nft' });

				if (this.currentSource.product.product_type ===  id_nft) {
					// remove comment to enable nft link to website
					//bbn.fn.link('https://nft.vivearts.com/en_US/series/photography-ofchina');
				}
				else {
					if (this.currentSource.product.stock) {
						this.post('actions/shop/cart/add', {
							id_product: this.currentSource.product.id,
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
        this.$set(this.source, 'id_product', a.id);
      },
      getProduct(){
        this.currentSource.product = {}
        this.currentSource.product.ok = false
        this.isOk = false
        this.post(this.root + 'cms/data/product', {
          id: this.currentSource.id_product
        }, d => {
          if(d.success){
            this.$nextTick(() => {
              this.currentSource.product = d.data
              this.currentSource.product.ok = true
              this.isOk = true
            })
            

          }
        })
      }
    },
    beforeMount(){
      if (this.currentSource.product && (this.mode === 'read')){
        if(this.currentSource.url){
          delete(this.currentSource.url)
        }
        this.$set(this.source, 'id_product',this.currentSource.product.id )
        this.getProduct();
      }
      else if(this.currentSource.id_product ){
        this.getProduct();
      }
			if(this.currentSource.showType === undefined){
				this.currentSource.showType = true;
			} 
      
		},
    watch:{
      'currentSource.id_product'(val){
        this.getProduct()
      }
    }
  };
})();