<div :class="[componentClass, 'bbn-w-100']">
  <div v-if="mode === 'edit'"
       class="bbn-padded">
    <div class="bbn-w-100 bbn-grid-fields">

      <label><?=_('Mode')?></label>
      <bbn-radio v-model="sliderMode"
                 :nullable="true"
                 :source="radioSource"/>

      <label v-if="sliderMode === 'publications'"><?=_('Type of articles')?></label>
      <bbn-dropdown :source="note + '/cms/data/types_notes'"
                    v-model="source.noteType"
                    @change="getSlideshowSource"
                    v-if="sliderMode === 'publications'"
                    ref="publicationdropdown"/>
      
      <label v-if="(sliderMode === 'publications') && this.showRootAlias"><?=_('Category')?></label>
      <bbn-dropdown :source="note + '/cms/data/types_notes/' + this.source.id_root_alias"
                    v-model="source.id_option"
                    :nullable="true"
                    sourceValue="id"
                    @change="getSlideshowSource"
                    v-if="(sliderMode === 'publications') && this.showRootAlias"
                    />
                    
      <label v-if="sliderMode === 'publications'"><?=_('Ordered by')?></label>
      <bbn-dropdown :source="orderFields"
                    v-model="source.order"
                    sourceValue="value"
                    @change="getSlideshowSource"
                    v-if="sliderMode === 'publications'"/>

      <label v-if="sliderMode === 'gallery'"><?=_('Gallery')?></label>
      <div v-if="sliderMode === 'gallery'" class="bbn-vmiddle">
        <bbn-dropdown :source="galleryListUrl"
                      source-value="id"
                      v-model="source.id_group"
                      ref="galleryList"
                      @change="getSlideshowSource"
                      :limit="0"/>
        <bbn-button icon="nf nf-fae-galery"
                    :notext="true"
                    @click="openMediasGroups"
                    class="bbn-left-sspace"
                    title="<?=_('Open galleries management')?>"/>
      </div>

      <label v-if="sliderMode === 'features'"><?=_('Feature')?></label>
      <bbn-dropdown :source="note + '/cms/data/features'"
                    v-model="source.id_feature"
                    @change="getSlideshowSource"
                    source-value="id"
                    v-if="sliderMode === 'features'"/>

      <label><?=_('Height')?> (px)</label>
      <bbn-range v-model="source.style.height"
                 :min="10"
                 :max="2000"
                 :step="10"
                 :show-reset="false"
                 :show-numeric="true"
                 :show-units="true"
                 :nullable="true"
                 unit="px"/>

      <label><?=_('Max slide in line')?></label>
      <div>
        <bbn-numeric v-model="source.max"
                      :step="1"
                      :min="1"
                      :default="1"
                      :nullable="false"
                      :max="5"
                      @change="adaptView"
                      />
      </div>
      <label><?=_('Min slide in line (mobile)')?></label>
      <div>
        <bbn-numeric v-model="source.min"
                    :step="1"
                    :min="1"
                    :default="1"
                    :max="5"
                    :nullable="false"
                    @change="adaptView"
                    />
      </div>
      <label><?=_('Limits')?></label>
      <bbn-numeric v-model="source.limit"
                   :min="source.max"
                   :nullable="false"
                   @change="getSlideshowSource"
                   />

      <label><?=_('Autoplay')?></label>
      <bbn-checkbox v-model="source.autoplay"
                    :value="1"
                    :novalue="0"/>

      <label><?=_('Arrows')?></label>
      <bbn-checkbox v-model="source.arrows"
                    :value="1"
                    :novalue="0"/>

      <label v-if="!!source.arrows"><?=_('Arrows position')?></label>
      <bbn-dropdown v-if="!!source.arrows"
                    v-model="source.arrowsPosition"
                    :source="arrowsPositions"/>

      <label><?=_('Preview')?></label>
      <bbn-checkbox v-model="source.preview"
                    :value="1"
                    :novalue="0"/>

      <label><?=_('Loop')?></label>
      <bbn-checkbox v-model="source.loop"
                    :value="1"
                    :novalue="0"/>

      <label><?=_('Show info')?></label>
      <bbn-checkbox v-model="source.info"
                    :value="1"
                    :novalue="0"/>
    </div>
  </div>
  <div v-else class="bbn-w-100" :style="source.style">
    <bbn-slideshow v-if="source.currentItems"
                   :source="source.currentItems"
                   ref="slideshow"
                   :arrows="!!source.arrows"
                   :arrows-position="source.arrowsPosition"
                   :auto-play="!!source.autoplay"
                   :loop="!!source.loop"
                   :preview="!!source.preview"
                   :show-info="!!source.info"
                   />
    <div v-else
         class="bbn-light bbn-lg">
      <?= _("No items") ?>
    </div>
  </div>
</div>
