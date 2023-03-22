<div :class="[componentClass, currentSource.optionalClass, 'bbn-w-100']"
     :style="currentSource.blockDistance ? ('margin-bottom:' + currentSource.blockDistance) : ''">
  <div v-if="mode === 'edit'"
       class="bbn-padded">
    <div class="bbn-w-100 bbn-grid-fields">
      <label><?=_('Css class')?><small> <?=_('(Optional)')?></small></label>
      <bbn-input v-model="currentSource.optionalClass"/>

      <label><?=_('Mode')?></label>
      <bbn-radio v-model="sliderMode"
                 :nullable="true"
                 :source="radioSource"/>

      <label v-if="sliderMode === 'publications'"><?=_('Type of articles')?></label>
      <bbn-dropdown :source="note + '/cms/data/types_notes'"
                    v-model="currentSource.noteType"
                    @change="getSlideshowSource"
                    v-if="sliderMode === 'publications'"
                    ref="publicationdropdown"/>
      
      <label v-if="(sliderMode === 'publications') && this.showRootAlias"><?=_('Category')?></label>
      <bbn-dropdown :source="note + '/cms/data/types_notes/' + this.currentSource.id_root_alias"
                    v-model="currentSource.id_option"
                    :nullable="true"
                    sourceValue="id"
                    @change="getSlideshowSource"
                    v-if="(sliderMode === 'publications') && this.showRootAlias"
                    />
                    
      <label v-if="sliderMode === 'publications'"><?=_('Ordered by')?></label>
      <bbn-dropdown :source="orderFields"
                    v-model="currentSource.order"
                    sourceValue="value"
                    @change="getSlideshowSource"
                    v-if="sliderMode === 'publications'"/>

      <label v-if="sliderMode === 'gallery'"><?=_('Gallery')?></label>
      <div v-if="sliderMode === 'gallery'" class="bbn-vmiddle">
        <bbn-dropdown :source="galleryListUrl"
                      source-value="id"
                      v-model="currentSource.id_group"
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

      <label v-if="sliderMode === 'features'"><?=_('Feature')?></label>
      <bbn-dropdown :source="note + '/cms/data/features'"
                    v-model="currentSource.content"
                    @change="getSlideshowSource"
                    source-value="id"
                    v-if="sliderMode === 'features'"/>

      <label><?=_('Height')?> (px)</label>
      <bbn-range v-model="currentSource.height"
                 :min="10"
                 :max="2000"
                 :step="10"
                 :show-reset="false"
                 :show-numeric="true"
                 :show-units="true"
                 :nullable="true"
                 unit="px"/>

      <label><?=_('Distance block below')?> (px)</label>
      <bbn-range v-model="currentSource.blockDistance"
                 :min="0"
                 :max="200"
                 :step="5"
                 :show-reset="false"
                 :show-numeric="true"
                 :show-units="true"
                 :nullable="true"
                 unit="px"/>

      <label><?=_('Title distance')?> (px)</label>
      <bbn-range v-model="currentSource.margin"
                 :min="-200"
                 :max="200"
                 :step="5"
                 :show-reset="false"
                 :show-numeric="true"
                 :show-units="true"
                 :nullable="true"
                 unit="px"/>

      <label><?=_('Title distance (mobile)')?> (px)</label>
      <bbn-range v-model="currentSource.marginMobile"
                 :min="-200"
                 :max="200"
                 :step="5"
                 :show-reset="false"
                 :show-numeric="true"
                 :show-units="true"
                 :nullable="true"
                 unit="px"/>


      <label><?=_('Image fit')?></label>
      <bbn-radio v-model="currentSource.fit"
                 :nullable="true"
                 :source="fitSource"/>
                 
      <label><?=_('Max slide in line')?></label>
      <div>
        <bbn-numeric v-model="currentSource.max"
                      :step="1"
                      :min="1"
                      :default="1"
                      :nullable="false"
                      :max="5"
                      />
      </div>
      <label><?=_('Min slide in line (mobile)')?></label>
      <div>
        <bbn-numeric v-model="currentSource.min"
                    :step="1"
                    :min="1"
                    :default="1"
                    :max="5"
                    :nullable="false"
                    />
      </div>
      <label v-if="sliderMode !== 'gallery'"><?=_('Limits')?></label>
      <bbn-numeric v-model="currentSource.limit"
                   :min="currentSource.max"
                   :nullable="false"
                   @change="getSlideshowSource"
                   v-if="sliderMode !== 'gallery'"
                   />

      <label><?=_('Autoplay')?></label>
      <bbn-checkbox v-model="currentSource.autoplay"
                    :value="1"
                    :novalue="0"/>

      <label><?=_('Arrows')?></label>
      <bbn-checkbox v-model="currentSource.arrows"
                    :value="1"
                    :novalue="0"/>

      <label v-if="!!currentSource.arrows"><?=_('Arrows position')?></label>
      <bbn-dropdown v-if="!!currentSource.arrows"
                    v-model="currentSource.arrowsPosition"
                    :source="arrowsPositions"/>

      <label><?=_('Preview')?></label>
      <bbn-checkbox v-model="currentSource.preview"
                    :value="1"
                    :novalue="0"/>

      <label><?=_('Loop')?></label>
      <bbn-checkbox v-model="currentSource.loop"
                    :value="1"
                    :novalue="0"/>

      <label><?=_('Show info')?></label>
      <bbn-checkbox v-model="currentSource.info"
                    :value="1"
                    :novalue="0"/>
    </div>
  </div>
  <div v-else class="bbn-w-100" :style="{'height':currentSource.height ? currentSource.height : '', 'width':currentSource.width ? currentSource.width :''}">
    <bbn-slideshow v-if="currentSource.content"
                   :source="currentSource.currentItems"
                   ref="slideshow"
                   :arrows="!!currentSource.arrows"
                   :arrows-position="currentSource.arrowsPosition"
                   :auto-play="!!currentSource.autoplay"
                   :loop="!!currentSource.loop"
                   :preview="!!currentSource.preview"
                   :show-info="!!currentSource.info"
                   />
    <div v-else
         class="bbn-light bbn-lg">
      <?= _("No items") ?>
    </div>
  </div>
</div>
