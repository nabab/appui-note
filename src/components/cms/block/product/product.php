<!-- HTML Document -->


<!-- HTML Document -->
<div :class="[componentClass, 'bbn-w-100']">
  <div v-if="mode === 'edit'">
    <div class='bbn-w-100 bbn-padding bbn-grid-fields'>
      <label class="bbn-l"><?=_("Product Picker")?></label>
        <div class="bbn-l">
          <bbn-search :source="shopRoot + 'products/list'"
                      source-text="title"
                      source-value="id"
                      component="appui-note-search-item"
                      source-url=""
                      :placeholder="placeholder"
                      @select="select"/>
        </div>

        <label class="bbn-l"><?=_("Show image")?></label>
        <div class="bbn-l">
          <bbn-switch v-model="source.showImage"
                      :value="true"
                      :novalue="false"
                      class="bbn-left-space"/>
        </div>

        <label class="bbn-l"><?=_("Show price")?></label>
        <div class="bbn-l">
          <bbn-switch v-model="source.showPrice"
                    :value="true"
                    :novalue="false"
                    class="bbn-left-space"/>
        </div>

        <label class="bbn-l"><?=_("Show edition")?></label>
        <div class="bbn-l">
          <bbn-switch v-model="source.showEdition"
                    :value="true"
                    :novalue="false"
                    class="bbn-left-space"/>
        </div>

        <label class="bbn-l"><?=_("Show type")?></label>
        <div class="bbn-l">
          <bbn-switch v-model="source.showType"
                    :value="true"
                    :novalue="false"
                    class="bbn-left-space"/>
        </div>

        <label class="bbn-l"><?=_("Show Sold out")?></label>
        <div class="bbn-l">
          <bbn-switch v-model="source.showSoldOut"
                      :value="true"
                      :novalue="false"
                      class="bbn-left-space"/>
        </div>

        <label class="bbn-l"><?=_("Show 'Add to cart' button ")?></label>
        <div class="bbn-l">
          <bbn-switch v-model="source.showButton"
                      :value="true"
                      :novalue="false"
                      class="bbn-left-space"/>
        </div>
    </div>
  </div>
  <div v-if="(mode === 'read')"
       class="bbn-w-100">
    <div v-if="showProduct"
         class="bbn-w-100 bbn-padded">
      <div class="bbn-container-ratio-4-3 bbn-bottom-smargin">
        <a v-if="productData.url"
           :href="productData.url">
          <img :src="imageSrc"
               class="bbn-top-left product-img"
               v-if="source.showImage">
        </a>
      </div>
      <a v-if="productData.url"
         class="bbn-large"
         :href="productData.url"
         v-html="productData.title"/>
      <p v-if="source.showPrice"
         class="product-price bbn-flex">
        <span v-if="productData.num_variants > 1"
              v-html="_('From') + '&nbsp;'"></span>
        <bbn-field :value="productData.price"
                    field="example"
                    mode="read"
                    type="money"
                    :decimals="2"
                    unit="€"/>
      </p>
      <p class="product-desc"
         v-if="source.showType"
         v-text="type"/>
      <p class="product-desc"
         v-if="source.showEdition"
         v-html="edition"/>
      <poc-product-soldout v-if="!productData.stock && source.showSoldOut"/>
      <button :class="['add-to-cart bbn-p bbn-upper bbn-vsmargin', {'bbn-disabled': disabled, 'bbn-p':!disabled}]"
              v-if="source.showButton"
              @click="addToCart"
              :disabled="disabled">
        <?=_("Add to cart")?>
      </button>
    </div>
  </div>
</div>
