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
        if(this.isOk && this.source.product.title){
          return this.source.product.title
        }
        return ''
      },
      showProduct(){
        if(this.isOk && this.source.product && this.source.product.ok){
          return true
        }
        return false
      },
      disabled(){
        if(this.isOk && !this.source.product.stock){
          return true;
        }
        else {
          return false
        }
			},
      type(){
        if(this.source.product.product_type && this.isOk){
          return bbn.fn.getField(bbn.opt.product_types,'text', 'value', this.source.product.product_type)
        }
      },
      edition(){
        if(this.source.product.id_edition && this.isOk){
          return bbn.fn.getField(bbn.opt.editions,'text', 'value', this.source.product.id_edition)
        }
      },
      
      imageSrc(){
        if(this.source.product.medias.length && this.isOk){
          return bbn.fn.getField(this.source.product.medias, 'path', 'id' , this.source.product.front_img)

        }
      }
    },
    methods:{

      addToCart(){
				let id_nft =  bbn.fn.getField(appui.options.product_types, "value", { code:'nft' });

				if (this.source.product.product_type ===  id_nft) {
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
        this.$set(this.source, 'url', a.url);
      },
      getProduct(){
        this.source.product = {}
        this.source.product.ok = false
        this.isOk = false
        this.post(this.root + 'cms/data/product', {
          url: this.source.url
        }, d => {
          if(d.success){
            this.$nextTick(() => {
              this.source.product = d.data
              this.source.product.ok = true
              this.isOk = true
            })
            

          }
        })
      }
    },
    beforeMount(){
      if (this.source.product && (this.mode === 'read')){
        this.source.url = this.source.product.url
        this.getProduct()
      }
			if(this.source.showType === undefined){
				this.source.showType = true;
			} 
      
		},
    watch:{
      'source.url'(val){
        this.getProduct()
      }
    }
  };
})();