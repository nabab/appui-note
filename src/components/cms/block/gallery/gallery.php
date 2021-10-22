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
									 :show-label="true"
									 :show-units="true"/>
    <label><?=_('Height')?></label>
    <bbn-range v-model="source.style.height"
									 :min="10"
									 :max="2000" 
									 :step="10"
									 :show-reset="false"
									 :show-label="true"
									 :show-units="true"/>
    <label><?=_('Image width')?></label>
    <bbn-range v-model="source.imageWidth"
									 :min="10"
									 :max="2000" 
									 :step="10"
									 :show-reset="false"
									 :show-label="true"/>
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
    <label><?=_('Scrollable')?></label>
    <bbn-checkbox v-model="source.scrollable"
                  :value="1"
                  :novalue="0"/>
    <label><?=_('Pageable')?></label>
    <bbn-checkbox v-model="source.pageable"
                  :value="1"
                  :novalue="0"/>
    <label><?=_('Footer')?></label>
    <bbn-checkbox v-model="source.pager"
                  :value="1"
                  :novalue="0"/>
    <label><?=_('Zoomable')?></label>
    <bbn-checkbox v-model="source.zoomable"
                  :value="1"
                  :novalue="0"/>
    <label><?=_('Resizable')?></label>
    <bbn-checkbox v-model="source.resizable"
                  :value="1"
                  :novalue="0"/>
    <label><?=_('Toolbar')?></label>
    <bbn-checkbox v-model="source.toolbar"
                  :value="1"
                  :novalue="0"/>
  </div>
  <div v-else
       class="bbn-flex"
       :style="align">
    <div class="bbn-block"
         :style="source.style">
      <bbn-gallery :source="gallerySourceUrl"
                  :data="{
                    idGroup: source.source
                  }"
                  ref="gallery"
                  :scrollable="!!source.scrollable"
                  :pageable="!!source.pageable"
                  :zoomable="!!source.zoomable"
                  :resizable="!!source.resizable"
                  :toolbar="!!source.toolbar"
                  path-name="path"
                  :itemWidth="source.imageWidth"
                  :pager="!!source.pager"/>
    </div>
  </div>
</div>
