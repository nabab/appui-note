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
    <div class="bbn-w-100 bbn-padded"
         v-if="showProduct">
      <div class="bbn-container-ratio-4-3 bbn-bottom-smargin">
        <a :href="source.content.url"
           v-if="source.content.url">
          <img :src="imageSrc"
               class="bbn-top-left product-img"
               v-if="source.showImage">
        </a>
      </div>
      <a class="bbn-large"
         v-if="source.content.url"
         :href="source.content.url"
         v-html="source.content.title"/>

      <p class="product-price bbn-flex" v-if="source.showPrice">
        <span v-if="source.content.num_variants > 1" v-html="_('From') + '&nbsp;'"></span>
        <bbn-field :value="source.content.price"
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

      <poc-product-soldout v-if="!source.content.stock && source.showSoldOut"/>

      <button :class="['add-to-cart bbn-p bbn-upper bbn-vsmargin', {'bbn-disabled': disabled, 'bbn-p':!disabled}]"
              v-if="source.showButton" 
              @click="addToCart">
        <?=_("Add to cart")?>
      </button>

    </div>
  </div>
</div>
