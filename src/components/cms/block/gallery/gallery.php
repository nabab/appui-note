<!-- HTML Document -->
<div :class="componentClass">
  <div bbn-if="mode === 'edit'"
       class="bbn-grid-fields">
    <label bbn-if="!isConfig"><?= _('Gallery') ?></label>
    <div bbn-if="!isConfig"
         class="bbn-vmiddle">
      <bbn-dropdown :source="galleryListUrl"
                    source-value="id"
                    bbn-model="source.content"
                    ref="galleryList"
                    :suggest="true"
                    :filterable="true"
                    :limit="0"/>
      <bbn-button icon="nf nf-fae-galery"
                  :notext="true"
                  @click="openMediasGroups"
                  class="bbn-left-sspace"
                  title="<?= _('Open galleries management') ?>"/>
    </div>

    <label bbn-if="isConfig || !isInConfig('style')"><?= _('Width') ?></label>
    <bbn-range bbn-if="isConfig || !isInConfig('style')"
               bbn-model="source.width"
               :min="10"
               :max="2000"
               :step="10"
               :show-reset="false"
               :show-numeric="true"
               :show-units="true"/>
    <label bbn-if="isConfig || !isInConfig('style')"><?= _('Height') ?></label>
    <bbn-range bbn-if="isConfig || !isInConfig('style')"
               bbn-model="source.height"
               :min="10"
               :max="2000"
               :step="10"
               :show-reset="false"
               :show-numeric="true"
               :show-units="true"/>

    <label bbn-if="isConfig || !isInConfig('crop')"><?= _('Crop Image') ?></label>
    <bbn-switch bbn-if="isConfig || !isInConfig('crop')"
                bbn-model="source.crop"
                :value="1"
                :novalue="0"/>

    <label bbn-if="isConfig || !isInConfig('imageWidth')"><?= _('Image width') ?> (%)</label>
    <bbn-range bbn-if="isConfig || !isInConfig('imageWidth')"
               bbn-model="source.imageWidth"
               :min="5"
               :max="100"
               :step="1"
               :show-reset="false"
               :show-numeric="true"
               unit="%"/>

    <label bbn-if="isConfig || !isInConfig('columnGap')"><?= _('Column gap') ?></label>
    <bbn-range bbn-if="isConfig || !isInConfig('columnGap')"
               bbn-model="source.columnGap"
               :min="0"
               :max="100"
               :step="1"
               :default="10"
               :show-reset="false"
               :show-numeric="true"/>

    <label bbn-if="isConfig || !isInConfig('align')"><?= _('Alignment') ?></label>
    <div bbn-if="isConfig || !isInConfig('align')">
      <div class="bbn-block">
        <bbn-radiobuttons :notext="true"
                          bbn-model="source.align"
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

    <label bbn-if="isConfig || !isInConfig('imageAlign')"><?= _('Image alignment') ?></label>
    <div bbn-if="isConfig || !isInConfig('imageAlign')">
      <div class="bbn-block">
        <bbn-radiobuttons :notext="true"
                          bbn-model="source.imageAlign"
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
                            text: _('Space between'),
                            value: 'space-between',
                            icon: 'nf nf-md-align_horizontal_distribute'
                          }, {
                            text: _('Space around'),
                            value: 'space-around',
                            icon: 'nf nf-md-align_horizontal_distribute'
                          }, {
                            text: _('Space evenly'),
                            value: 'space-evenly',
                            icon: 'nf nf-md-align_horizontal_distribute'
                          }, {
                            text: _('No value'),
                            value: null,
                            icon: 'nf nf-fa-times'
                          }]"/>
      </div>
    </div>

    <label><?= _('Mode') ?></label>
    <div class="bbn-block">
      <bbn-radiobuttons :notext="true"
                        bbn-model="source.mode"
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

    <label bbn-if="isConfig || !isInConfig('scrollable')"><?= _('Scrollable') ?></label>
    <bbn-switch bbn-if="isConfig || !isInConfig('acrollable')"
                bbn-model="source.scrollable"
                :value="1"
                :novalue="0"/>


    <label bbn-if="isConfig || !isInConfig('pageable')"><?= _('Pageable') ?></label>
    <bbn-switch bbn-if="isConfig || !isInConfig('pageable')"
                bbn-model="source.pageable"
                :value="1"
                :novalue="0"/>

    <label bbn-if="isConfig || !isInConfig('footer')"><?= _('Footer') ?></label>
    <bbn-switch bbn-if="isConfig || !isInConfig('footer')"
                bbn-model="source.pager"
                :value="1"
                :novalue="0"/>

    <label bbn-if="isConfig || !isInConfig('zoomable')"><?= _('Zoomable') ?></label>
    <bbn-switch bbn-if="isConfig || !isInConfig('zoomable')"
                bbn-model="source.zoomable"
                :value="1"
                :novalue="0"/>

    <label bbn-if="(isConfig || !isInConfig('info')) && !!source.zoomable"><?= _('Info') ?></label>
    <bbn-switch bbn-if="(isConfig || !isInConfig('info')) && !!source.zoomable"
                bbn-model="source.info"
                :value="1"
                :novalue="0"/>

    <label bbn-if="(isConfig || !isInConfig('sourceInfo')) && !!source.info"><?= _('Info field') ?></label>
    <bbn-dropdown bbn-if="(isConfig || !isInConfig('sourceInfo')) && !!source.info"
                  bbn-model="source.sourceInfo"
                  :source="sourceInfoList"/>

    <label bbn-if="isConfig || !isInConfig('resizable')"><?= _('Resizable') ?></label>
    <bbn-switch bbn-if="isConfig || !isInConfig('resizable')"
                bbn-model="source.resizable"
                :value="1"
                :novalue="0"/>

    <label bbn-if="isConfig || !isInConfig('toolbar')"><?= _('Toolbar') ?></label>
    <bbn-switch bbn-if="isConfig || !isInConfig('toolbar')"
                bbn-model="source.toolbar"
                :value="1"
                :novalue="0"/>
  </div>
  <div bbn-else-if="!source.content && $parent.selectable"
        class="bbn-alt-background bbn-middle bbn-lpadding"
        style="overflow: hidden">
    <i class="bbn-xxxxl nf nf-fae-galery"/>
  </div>
  <div bbn-else
       class="bbn-flex"
       :style="{'justify-content': source.align || ''}">
    <div class="bbn-block"
         :style="{
           'width': source.width,
           'height': source.height
         }">
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
                   :pager="!!source.pager"
                   :align="source.imageAlign"/>
    </div>
  </div>
</div>
