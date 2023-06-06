<!-- HTML Document -->
<div :class="componentClass">
  <div v-if="mode === 'edit'"
       class="bbn-grid-fields">
    <label v-if="!isConfig"><?=_('Gallery')?></label>
    <div v-if="!isConfig"
         class="bbn-vmiddle">
      <bbn-dropdown :source="galleryListUrl"
                    source-value="id"
                    v-model="source.content"
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
               v-model="source.width"
               :min="10"
               :max="2000"
               :step="10"
               :show-reset="false"
               :show-numeric="true"
               :show-units="true"/>
    <label v-if="isConfig || !isInConfig('style')"><?=_('Height')?></label>
    <bbn-range v-if="isConfig || !isInConfig('style')"
               v-model="source.height"
               :min="10"
               :max="2000"
               :step="10"
               :show-reset="false"
               :show-numeric="true"
               :show-units="true"/>

    <label v-if="isConfig || !isInConfig('crop')"><?=_('Crop Image')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('crop')"
                  v-model="source.crop"
                  :value="1"
                  :novalue="0"/>

    <label v-if="isConfig || !isInConfig('imageWidth')"><?=_('Image width')?> (%)</label>
    <bbn-range v-if="isConfig || !isInConfig('imageWidth')"
               v-model="source.imageWidth"
               :min="5"
               :max="100"
               :step="1"
               :show-reset="false"
               :show-numeric="true"
               unit="%"/>

    <label v-if="isConfig || !isInConfig('columnGap')"><?=_('Column gap')?></label>
    <bbn-range v-if="isConfig || !isInConfig('columnGap')"
               v-model="source.columnGap"
               :min="0"
               :max="100"
               :step="1"
               :default="10"
               :show-reset="false"
               :show-numeric="true"/>

    <label v-if="isConfig || !isInConfig('align')"><?=_('Alignment')?></label>
    <div v-if="isConfig || !isInConfig('align')">
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
                        v-model="source.mode"
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
                  v-model="source.scrollable"
                  :value="1"
                  :novalue="0"/>


    <label v-if="isConfig || !isInConfig('pageable')"><?=_('Pageable')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('pageable')"
                  v-model="source.pageable"
                  :value="1"
                  :novalue="0"/>

    <label v-if="isConfig || !isInConfig('footer')"><?=_('Footer')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('footer')"
                  v-model="source.pager"
                  :value="1"
                  :novalue="0"/>

    <label v-if="isConfig || !isInConfig('zoomable')"><?=_('Zoomable')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('zoomable')"
                  v-model="source.zoomable"
                  :value="1"
                  :novalue="0"/>

    <label v-if="(isConfig || !isInConfig('info')) && !!source.zoomable"><?=_('Info')?></label>
    <bbn-checkbox v-if="(isConfig || !isInConfig('info')) && !!source.zoomable"
                  v-model="source.info"
                  :value="1"
                  :novalue="0"/>

    <label v-if="(isConfig || !isInConfig('sourceInfo')) && !!source.info"><?=_('Info field')?></label>
    <bbn-dropdown v-if="(isConfig || !isInConfig('sourceInfo')) && !!source.info"
                  v-model="source.sourceInfo"
                  :source="sourceInfoList"/>

    <label v-if="isConfig || !isInConfig('resizable')"><?=_('Resizable')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('resizable')"
                  v-model="source.resizable"
                  :value="1"
                  :novalue="0"/>

    <label v-if="isConfig || !isInConfig('toolbar')"><?=_('Toolbar')?></label>
    <bbn-checkbox v-if="isConfig || !isInConfig('toolbar')"
                  v-model="source.toolbar"
                  :value="1"
                  :novalue="0"/>
  </div>
  <div v-else
       class="bbn-flex"
       :style="align">
    <div class="bbn-block"
         :style="{'width': source.width, 'height': source.height}">
      <bbn-gallery :source="gallerySourceUrl"
                   :class="{'cropped' : source.crop}"
                   :data="{idGroup: source.content}"
                   ref="gallery"
                   :scrollable="!!source.scrollable"
                   :pageable="!!source.pageable"
                   :zoomable="!!source.zoomable && (source.mode === 'fullscreen')"
                   :info="!!source.info"
                   :source-info="!!source.info ? source.sourceInfo : undefined"
                   :resizable="!!source.resizable"
                   :toolbar="!!source.toolbar"
                   path-name="path"
                   :item-width="itemWidth"
                   item-width-unit="%"
                   :column-gap="source.columnGap"
                   :pager="!!source.pager"/>
    </div>
  </div>
</div>
