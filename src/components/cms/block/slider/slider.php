<div :class="[componentClass, source.optionalClass, 'bbn-w-100']"
     :style="source.blockDistance ? ('margin-bottom:' + source.blockDistance) : ''">
  <div v-if="mode === 'edit'"
       class="bbn-padded">
    <div class="bbn-w-100 bbn-grid-fields">

      <label><?=_('Mode')?></label>
      <bbn-radio v-model="source.mode"
                 :source="radioSource"/>

      <template v-if="isPublications">
        <label><?=_('Type of articles')?></label>
        <bbn-dropdown :source="noteRoot + 'cms/data/types_notes'"
                      v-model="source.noteType"
                      @change="getSlideshowSource"
                      ref="publicationdropdown"/>

        <label v-if="showRootAlias"><?=_('Category')?></label>
        <bbn-dropdown v-if="showRootAlias"
                      :source="noteRoot + 'cms/data/types_notes/' + source.id_root_alias"
                      v-model="source.content"
                      :nullable="true"
                      sourceValue="id"
                      @change="getSlideshowSource"/>

        <label><?=_('Ordered by')?></label>
        <bbn-dropdown :source="orderFields"
                      v-model="source.order"
                      @change="getSlideshowSource"/>
      </template>

      <label v-if="isGallery"><?=_('Gallery')?></label>
      <div v-if="isGallery" class="bbn-vmiddle">
        <bbn-dropdown :source="galleryListUrl"
                      source-value="id"
                      v-model="source.content"
                      ref="galleryList"
                      @change="getSlideshowSource"
                      :suggest="true"
                      :filterable="true"
                      :limit="0"/>
        <bbn-button icon="nf nf-fae-galery"
                    :notext="true"
                    @click="openMediasGroups"
                    class="bbn-left-sspace"
                    title="<?=_('Open galleries management')?>"/>
      </div>

      <label v-if="isFeatures"><?=_('Feature')?></label>
      <bbn-dropdown v-if="isFeatures"
                    :source="noteRoot + 'cms/data/features'"
                    v-model="source.content"
                    @change="getSlideshowSource"
                    source-value="id"/>

      <label><?=_('Css class')?><small> <?=_('(Optional)')?></small></label>
      <bbn-input v-model="source.optionalClass"/>

      <label><?=_('Height')?></label>
      <bbn-range v-model="source.height"
                 :min="10"
                 :max="2000"
                 :step="10"
                 :show-reset="false"
                 :show-numeric="true"
                 :show-units="true"
                 :nullable="true"
                 unit="px"/>

      <label><?=_('Distance block below')?></label>
      <bbn-range v-model="source.blockDistance"
                 :min="0"
                 :max="200"
                 :step="5"
                 :show-reset="false"
                 :show-numeric="true"
                 :show-units="true"
                 :nullable="true"
                 unit="px"/>

      <label><?=_('Title distance')?></label>
      <bbn-range v-model="source.margin"
                 :min="-200"
                 :max="200"
                 :step="5"
                 :show-reset="false"
                 :show-numeric="true"
                 :show-units="true"
                 :nullable="true"
                 unit="px"/>

      <label><?=_('Title distance (mobile)')?></label>
      <bbn-range v-model="source.marginMobile"
                 :min="-200"
                 :max="200"
                 :step="5"
                 :show-reset="false"
                 :show-numeric="true"
                 :show-units="true"
                 :nullable="true"
                 unit="px"/>


      <label><?=_('Image fit')?></label>
      <bbn-radio v-model="source.fit"
                 :nullable="true"
                 :source="fitSource"/>

      <label><?=_('Max slide in line')?></label>
      <div>
        <bbn-numeric v-model="source.max"
                     :step="1"
                     :min="1"
                     :default="1"
                     :nullable="false"
                     :max="5"/>
      </div>

      <label><?=_('Min slide in line (mobile)')?></label>
      <div>
        <bbn-numeric v-model="source.min"
                    :step="1"
                    :min="1"
                    :default="1"
                    :max="5"
                    :nullable="false"/>
      </div>

      <label v-if="!isGallery"><?=_('Limits')?></label>
      <bbn-numeric v-if="!isGallery"
                   v-model="source.limit"
                   :min="source.max"
                   :nullable="false"
                   @change="getSlideshowSource"/>

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
  <div v-else-if="$parent.selectable && !source.content"
       class="bbn-alt-background bbn-middle bbn-lpadded bbn-w-100"
       style="overflow: hidden">
    <i class="bbn-xxxxl nf nf-md-table_row"/>
  </div>
  <div v-else
       class="bbn-w-100"
       :style="{
         height: source.height ? source.height : '',
         width: source.width ? source.width :''
       }">
    <bbn-slideshow v-if="currentItems"
                   :source="currentItems"
                   ref="slideshow"
                   :arrows="!!source.arrows"
                   :arrows-position="source.arrowsPosition"
                   :auto-play="!!source.autoplay"
                   :loop="!!source.loop"
                   :preview="!!source.preview"
                   :show-info="!!source.info"/>
    <div v-else
         class="bbn-light bbn-lg">
      <?= _("No items") ?>
    </div>
  </div>
</div>
