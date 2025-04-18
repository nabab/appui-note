<!-- HTML Document -->
<div :class="componentClass">
  <div bbn-if="mode === 'edit'"
       class="bbn-grid-fields bbn-w-100">
    <label><?= _('Gallery') ?></label>
    <div class="bbn-vmiddle">
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
    <label><?= _('Width') ?></label>
    <bbn-range bbn-model="source.width"
									 :min="10"
									 :max="2000" 
									 :step="10"
									 :show-reset="false"
									 :show-numeric="true"
									 :show-units="true"/>
    <label><?= _('Height') ?></label>
    <bbn-range bbn-model="source.height"
									 :min="10"
									 :max="2000" 
									 :step="10"
									 :show-reset="false"
									 :show-numeric="true"
									 :show-units="true"/>
    <label><?= _('Alignment') ?></label>
    <div>
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
                          icon: 'nf nf-md-fullscreen'
                        }]"/>
    </div>
    <label><?= _('Autoplay') ?></label>
    <bbn-switch bbn-model="source.autoplay"
                :value="1"
                :novalue="0"
                :title="_('Autoplay')"
                :no-icon="false"
                on-icon="nf nf-md-play"
                off-icon="nf nf-md-pause"/>
    <label><?= _('Arrows') ?></label>
    <bbn-switch bbn-model="source.arrows"
                :value="1"
                :novalue="0"
                :no-icon="false"
                on-icon="nf nf-oct-arrow_switch"
                off-icon="nf nf-oct-arrow_switch"/>
    <label bbn-if="!!source.arrows"><?= _('Arrows position') ?></label>
    <bbn-dropdown bbn-if="!!source.arrows"
                  bbn-model="source.arrowsPosition"
                  :source="arrowsPositions"/>
    <label><?= _('Preview') ?></label>
    <bbn-switch bbn-model="source.preview"
                :value="1"
                :novalue="0"
                :no-icon="false"
                on-icon="nf nf-md-table_row"
                off-icon="nf nf-md-table_row"/>
    <label><?= _('Loop') ?></label>
    <bbn-switch bbn-model="source.loop"
                :value="1"
                :novalue="0"
                :no-icon="false"
                on-icon="nf nf-md-repeat_variant"
                off-icon="nf nf-md-repeat_variant"/>
    <label><?= _('Show info') ?></label>
    <bbn-switch bbn-model="source.info"
                :value="1"
                :novalue="0"
                :no-icon="false"
                on-icon="nf nf-fa-info"
                off-icon="nf nf-fa-info"/>
  </div>
  <div bbn-else-if="!source.content && $parent.selectable"
        class="bbn-alt-background bbn-middle bbn-lpadding"
        style="overflow: hidden">
    <i class="bbn-xxxxl nf nf-md-view_carousel"/>
  </div>
  <div bbn-else
       class="bbn-flex"
       :style="align">
    <div class="bbn-block bbn-rel"
         :style="{'width': source.width, 'height': source.height}">
      <div bbn-if="isLoading"
           class="bbn-c">
        <bbn-loadicon :size="32"/>
      </div>
      <bbn-slideshow bbn-else-if="currentItems.length"
                    :source="currentItems"
                    ref="slideshow"
                    :arrows="!!source.arrows"
                    :arrows-position="source.arrowsPosition"
                    :auto-play="!!source.autoplay"
                    :loop="!!source.loop"
                    :preview="!!source.preview"
                    :show-info="!!source.info"
                    :item-clickable="true"
                    @clickitem="clickItem"/>
      <bbn-floater bbn-if="fullScreenView && fullScreenImg"
                   width="100%"
                   height="100%"
                   class="carousel-floater bbn-vmiddle"
                   @close="closeFullscreen"
                   :scrollable="false"
                   :closable="true">
        <div class="bbn-overlay bbn-middle">
          <img :src="fullScreenImg.path">
        </div>
      </bbn-floater>
    </div>
  </div>
</div>
