// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: ['source'],
    data() {
      return {
        root: appui.plugins['appui-note'] + '/',
        value: '',

        product: {}
      }
    },
    computed: {
      placeholder(){
        if(this.product.title){
          return this.product.title
        }
        return ''
      },
      showProduct(){
        if(this.product && this.product.ok){
          return true
        }
        return false
      },
      disabled(){
        if(!this.product.stock){
          return true;
        }
        else {
          return false
        }
			},
      type(){
        if(this.product.product_type){
          return bbn.fn.getField(bbn.opt.product_types,'text', 'value', this.product.product_type)
        }
      },
      edition(){
        if(this.product.id_edition){
          return bbn.fn.getField(bbn.opt.editions,'text', 'value', this.product.id_edition)
        }
      },
      
      imageSrc(){
        if(this.product.medias.length){
          return bbn.fn.getField(this.product.medias, 'path', 'id' , this.product.front_img)

        }
      }
    },
    methods:{
      addToCart(){
				let id_nft =  bbn.fn.getField(appui.options.product_types, "value", { code:'nft' });

				if (this.product.product_type ===  id_nft) {
					// remove comment to enable nft link to website
					//bbn.fn.link('https://nft.vivearts.com/en_US/series/photography-ofchina');
				}
				else {
					if (this.product.stock) {
						this.post('actions/shop/cart/add', {
							id_product: this.product.id,
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
        this.product = {}
        this.product.ok = false
        this.isOk = false
        this.post(this.root + 'cms/data/product', {
          url: this.source.url
        }, d => {
          if(d.success){
            this.$nextTick(() => {
              this.product = d.data
              this.product.ok = true
              this.isOk = true
            })
            

          }
        })
      }
    },
    beforeMount(){
      if (this.source.product && this.source.product.url){
        this.source.url = this.source.product.url
      }

      if (this.product && (this.mode === 'read')){
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