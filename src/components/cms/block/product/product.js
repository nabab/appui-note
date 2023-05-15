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
        if(this.isOk && this.source.content.title){
          return this.source.content.title
        }
        return ''
      },
      showProduct(){
        if(this.isOk && this.source.content && this.source.content.ok){
          return true
        }
        return false
      },
      disabled(){
        if(this.isOk && !this.source.content.stock){
          return true;
        }
        else {
          return false
        }
			},
      type(){
        if(this.source.content.product_type && this.isOk){
          return bbn.fn.getField(bbn.opt.product_types,'text', 'value', this.source.content.product_type)
        }
      },
      edition(){
        if(this.source.content.id_edition && this.isOk){
          return bbn.fn.getField(bbn.opt.editions,'text', 'value', this.source.content.id_edition)
        }
      },
      
      imageSrc(){
        if(this.source.content.medias.length && this.isOk){
          return bbn.fn.getField(this.source.content.medias, 'path', 'id' , this.source.content.front_img)

        }
      }
    },
    methods:{

      addToCart(){
				let id_nft =  bbn.fn.getField(appui.options.product_types, "value", { code:'nft' });

				if (this.source.content.product_type ===  id_nft) {
					// remove comment to enable nft link to website
					//bbn.fn.link('https://nft.vivearts.com/en_US/series/photography-ofchina');
				}
				else {
					if (this.source.content.stock) {
						this.post('actions/shop/cart/add', {
							id_product: this.source.content.id,
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
        this.source.content = {}
        this.source.content.ok = false
        this.isOk = false
        this.post(this.root + 'cms/data/product', {
          id: this.source.id_product
        }, d => {
          if(d.success){
            this.$nextTick(() => {
              this.source.content = d.data
              this.source.content.ok = true
              this.isOk = true
            })
            

          }
        })
      }
    },
    beforeMount(){
      if (this.source.content && (this.mode === 'read')){
        if(this.source.url){
          delete(this.source.url)
        }
        this.$set(this.source, 'id_product', this.source.content.id )
        this.getProduct();
      }
      else if(this.source.id_product ){
        this.getProduct();
      }
			if(this.source.showType === undefined){
				this.source.showType = true;
			}
		},
    watch:{
      'source.id_product'(val){
        this.getProduct()
      }
    }
  };
})();