<div :class="[componentClass, 'bbn-w-100']">
	<div v-if="mode === 'edit'"
			 class="bbn-grid-fields bbn-padded"
	>
		<label><?=_('Type of articles')?></label>
		<bbn-dropdown :source="note + '/cms/data/types_notes'"
									v-model="source.noteType"
									@change="getSlideshowSource"
		/>
		
		<label><?=_('Ordered by')?></label>
		<bbn-dropdown :source="orderFields"
									v-model="source.order"
									sourceValue="value"
                  @change="getSlideshowSource"
		/>
		
		<label><?=_('Height')?> (px)</label>
		<bbn-range v-model="source.style.height"
							 :min="10"
							 :max="410"
							 :step="10"
							 :show-reset="false"
							 :show-numeric="true"
							 unit="px"
               />

		<label><?=_('Max slide in line')?></label>
		<bbn-numeric v-model="source.max"
								 :step="1"
								 :min="1"
								 :default="1"
								 :nullable="false"
								 :max="5"
                 @change="adaptView"
		/>
		
		<label><?=_('Min slide in line (mobile)')?></label>
		<bbn-numeric v-model="source.min"
								 :step="1"
								 :min="1"
								 :default="1"
								 :max="5"
								 :nullable="false"
                 @change="adaptView"

		/>
		
		<label><?=_('Limits')?></label>
		<bbn-numeric v-model="source.limit"
								 :step="10"
								 :min="10"
								 :nullable="false"
                 @change="getSlideshowSource"
		/>
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
	<div v-else class="bbn-w-100" :style="source.style">
      <bbn-slideshow v-if="source.currentItems && source.currentItems.length"
                     :source="source.currentItems"
                     ref="slideshow"
                     :arrows="!!source.arrows"
                     :auto-play="!!source.autoplay"
                     :loop="!!source.loop"
                     :preview="!!source.preview"
                     :show-info="!!source.info"
                     />
    </div>
	</div>
</div>