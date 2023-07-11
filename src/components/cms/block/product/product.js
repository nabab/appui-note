// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-note-cms-block']],
    props: ['source'],
    data() {
      return {
        root: appui.plugins['appui-note'] + '/',
        shopRoot: appui.plugins['appui-shop'] + '/',
        value: '',
        isOk: false,
        productData: {}
      }
    },
    computed: {
      placeholder(){
        if (this.isOk && this.productData.title) {
          return this.productData.title
        }
        return '';
      },
      showProduct(){
        return this.isOk && !!Object.keys(this.productData).length;
      },
      disabled(){
        return this.isOk && !this.productData.stock;
			},
      type(){
        if (this.isOk && !!this.productData.product_type) {
          return bbn.fn.getField(bbn.opt.product_types,'text', 'value', this.productData.product_type);
        }
      },
      edition(){
        if (this.isOk && !!this.productData.id_edition) {
          return bbn.fn.getField(bbn.opt.editions,'text', 'value', this.productData.id_edition);
        }
      },
      imageSrc(){
        if (this.isOk && !!this.productData.medias?.length) {
          return bbn.fn.getField(this.productData.medias, 'path', 'id' , this.productData.front_img);
        }
      }
    },
    methods:{
      addToCart(){
				let id_nft =  bbn.fn.getField(appui.options.product_types, "value", {code: 'nft'});
				if (this.productData.product_type ===  id_nft) {
					// remove comment to enable nft link to website
					//bbn.fn.link('https://nft.vivearts.com/en_US/series/photography-ofchina');
				}
				else {
					if (this.productData.stock) {
						this.post('actions/shop/cart/add', {
							id_product: this.productData.id,
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
        this.$set(this.source, 'content', a.id);
      },
      getProduct(){
        this.$set(this, 'productData', {});
        this.isOk = false
        this.post(this.root + 'cms/data/product', {
          id: this.source.content
        }, d => {
          if (d.success) {
            this.$set(this, 'productData', d.data);
            this.isOk = true;
          }
        })
      }
    },
    beforeMount(){
      if (!this.source.content && !!this.source.id_product) {
        //this.$set(this.source, 'content', this.source.id_product);
        //delete this.source.id_product;
      }
      if (this.source.content && (this.mode === 'read')){
        if(this.source.url){
          delete(this.source.url)
        }
        this.getProduct();
      }
      if(this.source.showType === undefined){
				this.source.showType = true;
			}
		},
    watch:{
      'source.content'(){
        this.getProduct()
      }
    }
  };
})();
