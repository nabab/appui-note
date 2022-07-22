<!-- HTML Document -->
<div :class="componentClass">
  <div v-if="mode === 'edit'"
       class="bbn-grid-fields bbn-padded">
    <label><?=_('Gallery')?></label>
    <div class="bbn-vmiddle">
      <bbn-dropdown :source="galleryListUrl"
                    source-value="id"
                    v-model="source.source"
                    ref="galleryList"
                    :suggest="true"
                    :filterable="true"
                    :limit="0"/>
      <bbn-button icon="nf nf-fae-galery"
                  :notext="true"
                  @click="openMediasGroups"
                  class="bbn-left-sspace"
                  title="<?=_('Open galleries management')?>"/>
    </div>
    <label><?=_('Width')?></label>
    <bbn-range v-model="source.style.width"
									 :min="10"
									 :max="2000" 
									 :step="10"
									 :show-reset="false"
									 :show-numeric="true"
									 :show-units="true"/>
    <label><?=_('Height')?></label>
    <bbn-range v-model="source.style.height"
									 :min="10"
									 :max="2000" 
									 :step="10"
									 :show-reset="false"
									 :show-numeric="true"
									 :show-units="true"/>
    <label><?=_('Alignment')?></label>
    <div>
      <div class="bbn-block">
        <bbn-radiobuttons :notext="true"
                          v-model="source.align"
                          :source="[{
                            text: _('Align left'),
                            value: 'left',
                            icon: 'nf nf-fa-align_left'
                          }, {
                            text: _('Align center'),
                            value: 'center',
                            icon: 'nf nf-fa-align_center'
                          }, {
                            text: _('Align right'),
                            value: 'right',
                            icon: 'nf nf-fa-align_right'
                          }]"/>
      </div>
    </div>
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
  <div v-else
       class="bbn-flex"
       :style="align">
    <div class="bbn-block bbn-rel"
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
</div>
