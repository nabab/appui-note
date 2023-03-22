<!-- HTML Document -->
<div :class="componentClass">
  <div v-if="mode === 'edit'"
       class="bbn-grid-fields">
    <label v-if="!isConfig"><?=_('Gallery')?></label>
    <div v-if="!isConfig"
         class="bbn-vmiddle">
      <bbn-dropdown :source="galleryListUrl"
                    source-value="id"
                    v-model="currentSource.content"
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

    <label v-if="isConfig || !isInConfig('style')"><?=_('Width')?></label>
    <bbn-range v-if="isConfig || !isInConfig('style')"
               v-model="currentSource.width"
               :min="10"
               :max="2000"
               :step="10"
               :show-reset="false"
               :show-numeric="true"
               :show-units="true"/>
    <label v-if="isConfig || !isInConfig('style')"><?=_('Height')?></label>
    <bbn-range v-if="isConfig || !isInConfig('style')"
               v-model="currentSource.height"
               :min="10"
               :max="2000"
               :step="10"
               :show-reset="false"
               :show-numeric="true"
               :show-units="true"/>
    
    <label v-if="isConfig || !isInConfig('crop')"><?=_('Crop Image')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('crop')"
                  v-model="currentSource.crop"
                  :value="1"
                  :novalue="0"/>

    <label v-if="isConfig || !isInConfig('imageWidth')"><?=_('Image width')?> (%)</label>
    <bbn-range v-if="isConfig || !isInConfig('imageWidth')"
               v-model="currentSource.imageWidth"
               :min="5"
               :max="100"
               :step="1"
               :show-reset="false"
               :show-numeric="true"
               unit="%"
               />
    
    <label v-if="isConfig || !isInConfig('columnGap')"><?=_('Column gap')?></label>
    <bbn-range v-if="isConfig || !isInConfig('columnGap')"
               v-model="currentSource.columnGap"
               :min="2"
               :max="100"
               :step="1"
               :default="10"
               :show-reset="false"
               :show-numeric="true"
               />
    <label v-if="isConfig || !isInConfig('align')"><?=_('Alignment')?></label>
    <div v-if="isConfig || !isInConfig('align')">
      <div class="bbn-block">
        <bbn-radiobuttons :notext="true"
                          v-model="currentSource.align"
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
                                   }, {
                                   text: _('No value'),
                                   value: null,
                                   icon: 'nf nf-fa-times'
                                   }]"/>
      </div>
    </div>
    
    <label><?=_('Mode')?></label>
    <div class="bbn-block">
      <bbn-radiobuttons :notext="true"
                        v-model="currentSource.mode"
                        :source="[{
                          text: _('Link'),
                          value: 'link',
                          icon: 'nf nf-fa-link'
                        }, {
                          text: _('Fullscreen'),
                          value: 'fullscreen',
                          icon: 'nf nf-mdi-fullscreen'
                        }]"/>
    </div>
    <label v-if="isConfig || !isInConfig('scrollable')"><?=_('Scrollable')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('acrollable')"
                  v-model="currentSource.scrollable"
                  :value="1"
                  :novalue="0"/>

    <label v-if="isConfig || !isInConfig('pageable')"><?=_('Pageable')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('pageable')"
                  v-model="currentSource.pageable"
                  :value="1"
                  :novalue="0"/>

    <label v-if="isConfig || !isInConfig('footer')"><?=_('Footer')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('footer')"
                  v-model="currentSource.pager"
                  :value="1"
                  :novalue="0"/>

    <label v-if="isConfig || !isInConfig('zoomable')"><?=_('Zoomable')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('zoomable')"
                  v-model="currentSource.zoomable"
                  :value="1"
                  :novalue="0"/>

    <label v-if="(isConfig || !isInConfig('info')) && !!currentSource.zoomable"><?=_('Info')?></label>
    <bbn-checkbox v-if="(isConfig || !isInConfig('info')) && !!currentSource.zoomable"
                  v-model="currentSource.info"
                  :value="1"
                  :novalue="0"/>

    <label v-if="(isConfig || !isInConfig('sourceInfo')) && !!currentSource.info"><?=_('Info field')?></label>
    <bbn-dropdown v-if="(isConfig || !isInConfig('sourceInfo')) && !!currentSource.info"
                  v-model="currentSource.sourceInfo"
                  :source="sourceInfoList"/>

    <label v-if="isConfig || !isInConfig('resizable')"><?=_('Resizable')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('resizable')"
                  v-model="currentSource.resizable"
                  :value="1"
                  :novalue="0"/>

    <label v-if="isConfig || !isInConfig('toolbar')"><?=_('Toolbar')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('toolbar')"
                  v-model="currentSource.toolbar"
                  :value="1"
                  :novalue="0"/>

  </div>
  <div v-else
       class="bbn-flex"
       :style="align">
    <div class="bbn-block"
         :style="{'width': currentSource.width, 'height': currentSource.height}">
      <bbn-gallery :source="gallerySourceUrl"
                   :class="{'cropped' : currentSource.crop}"
                   :data="{
                          idGroup: currentSource.content
                          }"
                   ref="gallery"
                   @resize="getItemWidth"
                   :scrollable="!!currentSource.scrollable"
                   :pageable="!!currentSource.pageable"
                   :zoomable="!!currentSource.zoomable && (currentSource.mode === 'fullscreen')"
                   :info="!!currentSource.info"
                   :source-info="!!currentSource.info ? currentSource.sourceInfo : undefined"
                   :resizable="!!currentSource.resizable"
                   :toolbar="!!currentSource.toolbar"
                   path-name="path"
                   :itemWidth="itemWidth"
                   :columnGap="currentSource.columnGap"
                   :pager="!!currentSource.pager"/>
    </div>
  </div>
</div>
