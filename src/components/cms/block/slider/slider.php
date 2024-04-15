<div :class="[componentClass, source.optionalClass, 'bbn-w-100']"
     :style="source.blockDistance ? ('margin-bottom:' + source.blockDistance) : ''">
  <div bbn-if="mode === 'edit'"
       class="bbn-w-100 bbn-grid-fields">

    <label><?= _('Mode') ?></label>
    <bbn-radio bbn-model="source.mode"
                :source="radioSource"
                :vertical="true"/>

    <template bbn-if="isPublications">
      <label><?= _('Type of articles') ?></label>
      <bbn-dropdown :source="noteRoot + 'cms/data/types_notes'"
                    bbn-model="source.noteType"
                    @change="getSlideshowSource"
                    ref="publicationdropdown"/>

      <label bbn-if="showRootAlias"><?= _('Category') ?></label>
      <bbn-dropdown bbn-if="showRootAlias"
                    :source="noteRoot + 'cms/data/types_notes/' + source.id_root_alias"
                    bbn-model="source.content"
                    :nullable="true"
                    sourceValue="id"
                    @change="getSlideshowSource"/>

      <label><?= _('Ordered by') ?></label>
      <bbn-dropdown :source="orderFields"
                    bbn-model="source.order"
                    @change="getSlideshowSource"/>
    </template>

    <label bbn-if="isGallery"><?= _('Gallery') ?></label>
    <div bbn-if="isGallery" class="bbn-vmiddle">
      <bbn-dropdown :source="galleryListUrl"
                    source-value="id"
                    bbn-model="source.content"
                    ref="galleryList"
                    @change="getSlideshowSource"
                    :suggest="true"
                    :filterable="true"
                    :limit="0"/>
      <bbn-button icon="nf nf-fae-galery"
                  :notext="true"
                  @click="openMediasGroups"
                  class="bbn-left-sspace"
                  title="<?= _('Open galleries management') ?>"/>
    </div>

    <label bbn-if="isFeatures"><?= _('Feature') ?></label>
    <bbn-dropdown bbn-if="isFeatures"
                  :source="noteRoot + 'cms/data/features'"
                  bbn-model="source.content"
                  @change="getSlideshowSource"
                  source-value="id"/>

    <label><?= _('Css class')?><br><small><?=_('(Optional)') ?></small></label>
    <bbn-input bbn-model="source.optionalClass"/>

    <label><?= _('Height') ?></label>
    <bbn-range bbn-model="source.height"
                :min="10"
                :max="2000"
                :step="10"
                :show-reset="false"
                :show-numeric="true"
                :show-units="true"
                :nullable="true"
                unit="px"/>

    <label><?= _('Distance block below') ?></label>
    <bbn-range bbn-model="source.blockDistance"
                :min="0"
                :max="200"
                :step="5"
                :show-reset="false"
                :show-numeric="true"
                :show-units="true"
                :nullable="true"
                unit="px"/>

    <label><?= _('Title distance') ?></label>
    <bbn-range bbn-model="source.margin"
                :min="-200"
                :max="200"
                :step="5"
                :show-reset="false"
                :show-numeric="true"
                :show-units="true"
                :nullable="true"
                unit="px"/>

    <label><?= _('Title distance')?><br><small><?=_("(mobile)") ?></small></label>
    <bbn-range bbn-model="source.marginMobile"
                :min="-200"
                :max="200"
                :step="5"
                :show-reset="false"
                :show-numeric="true"
                :show-units="true"
                :nullable="true"
                unit="px"/>


    <label><?= _('Image fit') ?></label>
    <bbn-radiobuttons :source="fitSource"
                      bbn-model="source.fit"/>


    <label><?= _('Max slide in line') ?></label>
    <bbn-numeric bbn-model="source.max"
                  :step="1"
                  :min="1"
                  :default="1"
                  :nullable="false"
                  :max="5"/>

    <label><?= _('Min slide in line')?><br><small><?=_("(mobile)") ?></small></label>
    <bbn-numeric bbn-model="source.min"
                :step="1"
                :min="1"
                :default="1"
                :max="5"
                :nullable="false"/>

    <label bbn-if="!isGallery"><?= _('Limits') ?></label>
    <bbn-numeric bbn-if="!isGallery"
                  bbn-model="source.limit"
                  :min="source.max"
                  :nullable="false"
                  @change="getSlideshowSource"/>

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
  <div bbn-else-if="$parent.selectable && !source.content"
       class="bbn-alt-background bbn-middle bbn-lpadded bbn-w-100"
       style="overflow: hidden">
    <i class="bbn-xxxxl nf nf-md-table_row"/>
  </div>
  <div bbn-else
       class="bbn-w-100"
       :style="{
         height: source.height ? source.height : '',
         width: source.width ? source.width :''
       }">
    <bbn-slideshow bbn-if="currentItems"
                   :source="currentItems"
                   ref="slideshow"
                   :arrows="!!source.arrows"
                   :arrows-position="source.arrowsPosition"
                   :auto-play="!!source.autoplay"
                   :loop="!!source.loop"
                   :preview="!!source.preview"
                   :show-info="!!source.info"/>
    <div bbn-else
         class="bbn-light bbn-lg">
      <?= _("No items") ?>
    </div>
  </div>
</div>
