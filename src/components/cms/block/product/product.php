<!-- HTML Document -->


<!-- HTML Document -->
<div :class="[componentClass, 'bbn-w-100']">
  <div bbn-if="mode === 'edit'"
       class='bbn-w-100 bbn-grid-fields'>
    <label class="bbn-l"><?= _("Product Picker") ?></label>
      <div class="bbn-l">
        <bbn-search :source="shopRoot + 'products/list'"
                    source-text="title"
                    source-value="id"
                    component="appui-note-search-item"
                    source-url=""
                    :placeholder="placeholder"
                    @select="select"/>
      </div>

      <label class="bbn-l"><?= _("Show image") ?></label>
      <div class="bbn-l">
        <bbn-switch bbn-model="source.showImage"
                    :value="true"
                    :novalue="false"
                    class="bbn-left-space"/>
      </div>

      <label class="bbn-l"><?= _("Show price") ?></label>
      <div class="bbn-l">
        <bbn-switch bbn-model="source.showPrice"
                  :value="true"
                  :novalue="false"
                  class="bbn-left-space"/>
      </div>

      <label class="bbn-l"><?= _("Show edition") ?></label>
      <div class="bbn-l">
        <bbn-switch bbn-model="source.showEdition"
                  :value="true"
                  :novalue="false"
                  class="bbn-left-space"/>
      </div>

      <label class="bbn-l"><?= _("Show type") ?></label>
      <div class="bbn-l">
        <bbn-switch bbn-model="source.showType"
                  :value="true"
                  :novalue="false"
                  class="bbn-left-space"/>
      </div>

      <label class="bbn-l"><?= _("Show Sold out") ?></label>
      <div class="bbn-l">
        <bbn-switch bbn-model="source.showSoldOut"
                    :value="true"
                    :novalue="false"
                    class="bbn-left-space"/>
      </div>

      <label class="bbn-l"><?= _("Show 'Add to cart' button ") ?></label>
      <div class="bbn-l">
        <bbn-switch bbn-model="source.showButton"
                    :value="true"
                    :novalue="false"
                    class="bbn-left-space"/>
      </div>
  </div>
  <div bbn-else
       class="bbn-w-100">
    <div bbn-if="showProduct"
         class="bbn-w-100 bbn-padding">
      <div class="bbn-container-ratio-4-3 bbn-bottom-smargin">
        <a bbn-if="productData.url"
           :href="productData.url">
          <img :src="imageSrc"
               class="bbn-top-left product-img"
               bbn-if="source.showImage">
        </a>
      </div>
      <a bbn-if="productData.url"
         class="bbn-large"
         :href="productData.url"
         bbn-html="productData.title"/>
      <p bbn-if="source.showPrice"
         class="product-price bbn-flex">
        <span bbn-if="productData.num_variants > 1"
              bbn-html="_('From') + '&nbsp;'"></span>
        <bbn-field :value="productData.price"
                    field="example"
                    mode="read"
                    type="money"
                    :decimals="2"
                    unit="€"/>
      </p>
      <p class="product-desc"
         bbn-if="source.showType"
         bbn-text="type"/>
      <p class="product-desc"
         bbn-if="source.showEdition"
         bbn-html="edition"/>
      <poc-product-soldout bbn-if="!productData.stock && source.showSoldOut"/>
      <button :class="['add-to-cart bbn-p bbn-upper bbn-vsmargin', {'bbn-disabled': disabled, 'bbn-p':!disabled}]"
              bbn-if="source.showButton"
              @click="addToCart"
              :disabled="disabled">
        <?= _("Add to cart") ?>
      </button>
    </div>
    <div bbn-else-if="$parent.selectable"
         class="bbn-alt-background bbn-middle bbn-lpadding bbn-w-100"
         style="overflow: hidden">
      <i class="bbn-xxxxl nf nf-cod-package"/>
    </div>
  </div>
</div>
