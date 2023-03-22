<!-- HTML Document -->


<!-- HTML Document -->
<div :class="[componentClass, 'bbn-w-100']">
  <div v-if="mode === 'edit'">
        
    <div class='bbn-w-100 bbn-padding bbn-grid-fields'>
        <label class="bbn-l"><?=_("Product Picker")?></label>
        <div class="bbn-l">
          <bbn-search source="admin/shop/products/list"
                      source-text="title"
                      source-value="id"
                      component="appui-note-search-item"
                      source-url=""
                      :placeholder="placeholder"
                      @select="select"/>
        </div>
        <label class="bbn-l"><?=_("Show image")?></label>
        <div class="bbn-l">
          <bbn-switch v-model="currentSource.showImage"
                      :value="true"
                      :novalue="false"
                      class="bbn-left-space"/>
        </div>
        <label class="bbn-l"><?=_("Show price")?></label>
        <div class="bbn-l">
          <bbn-switch v-model="currentSource.showPrice"
                    :value="true"
                    :novalue="false"
                    class="bbn-left-space"/>
        </div>
        <label class="bbn-l"><?=_("Show edition")?></label>
        <div class="bbn-l">
          <bbn-switch v-model="currentSource.showEdition"
                    :value="true"
                    :novalue="false"
                    class="bbn-left-space"/>
        </div>
        <label class="bbn-l"><?=_("Show type")?></label>
        <div class="bbn-l">
          <bbn-switch v-model="currentSource.showType"
                    :value="true"
                    :novalue="false"
                    class="bbn-left-space"/>
        </div>
        <label class="bbn-l"><?=_("Show Sold out")?></label>
        <div class="bbn-l">
          <bbn-switch v-model="currentSource.showSoldOut"
                      :value="true"
                      :novalue="false"
                      class="bbn-left-space"/>
        </div>
        <label class="bbn-l"><?=_("Show 'Add to cart' button ")?></label>
        <div class="bbn-l">
          <bbn-switch v-model="currentSource.showButton"
                      :value="true"
                      :novalue="false"
                      class="bbn-left-space"/>
        </div>
    </div>
  </div>
  <div v-if="(mode === 'read')"
       class="bbn-w-100">
    <div class="bbn-w-100 bbn-padded" v-if="showProduct">
      <div class="bbn-container-ratio-4-3 bbn-bottom-smargin">
        <a :href="currentSource.product.url" v-if="currentSource.product.url">
          <img :src="imageSrc" class="bbn-top-left product-img" v-if="currentSource.showImage">
        </a>
      </div>
      <a class="bbn-large"
         v-if="currentSource.product.url"
         :href="currentSource.product.url"
        v-html="currentSource.product.title"></a>

      <p class="product-price bbn-flex" v-if="currentSource.showPrice">
        <span v-if="currentSource.product.num_variants > 1" v-html="_('From') + '&nbsp;'"></span>
        <bbn-field :value="currentSource.product.price"
                    field="example"
                    mode="read"
                    type="money"
                    :decimals="2"
                    unit="€"></bbn-field>
      </p>

      <p class="product-desc"
         v-if="currentSource.showType"
         v-text="type"></p>

      <p class="product-desc"
         v-if="currentSource.showEdition"
         v-html="edition"></p>
      <poc-product-soldout v-if="!currentSource.product.stock && currentSource.showSoldOut"/>
      <button :class="['add-to-cart bbn-p bbn-upper bbn-vsmargin', {'bbn-disabled': disabled, 'bbn-p':!disabled}]"
              v-if="currentSource.showButton" 
              @click="addToCart"><?=_("Add to cart")?></button>

    </div>
  </div>
</div>
