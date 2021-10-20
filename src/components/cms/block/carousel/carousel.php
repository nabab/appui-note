<!-- HTML Document -->
<div :class="componentClass">
  <div v-if="mode === 'edit'"
       class="bbn-grid-fields bbn-padded">
    <label><?=_('Gallery')?></label>
    <div class="bbn-vmiddle">
      <bbn-dropdown :source="galleries"
                    v-model="source.source"/>
      <bbn-button icon="nf nf-fae-galery"
                  :notext="true"
                  @click="openMediasGroups"
                  class="bbn-left-sspace"/>
    </div>
    <label><?=_('Width')?></label>
    <div class="bbn-flex-width bbn-vmiddle">
      <bbn-cursor v-model="currentWidth"
                  :min="10"
                  :max="2000" 
                  :step="10"
                  class="bbn-flex-fill bbn-right-sspace"
                  :unit="currentWidthUnit"/>
      <bbn-dropdown v-model="currentWidthUnit"
                    :source="units"
                    style="width: 6em"/>
    </div>
    <label><?=_('Height')?></label>
    <div class="bbn-flex-width bbn-vmiddle">
      <bbn-cursor v-model="currentHeight"
                  :min="10"
                  :max="2000" 
                  :step="10"
                  class="bbn-flex-fill bbn-right-sspace"
                  :unit="currentHeightUnit"/>
      <bbn-dropdown v-model="currentHeightUnit"
                    :source="units"
                    style="width: 6em"/>
    </div>
    <label><?=_('Autoplay')?></label>
    <bbn-checkbox v-model="source.autoplay"
                  :value="1"
                  :novalue="0"/>
    <label><?=_('Arrows')?></label>
    <bbn-checkbox v-model="source.arrows"
                  :value="1"
                  :novalue="0"/>
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
  <div v-else
       class="bbn-rel"
       :style="source.style">
    <bbn-slideshow v-if="currentItems.length"
                   :source="currentItems"
                   ref="slideshow"
                   :arrows="!!source.arrows"
                   :auto-play="!!source.autoplay"
                   :loop="!!source.loop"
                   :preview="!!source.preview"
                   :show-info="!!source.info"/>
  </div>
</div>
