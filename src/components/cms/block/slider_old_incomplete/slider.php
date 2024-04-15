<div :class="[componentClass, 'bbn-w-100']">
	<div bbn-if="mode === 'edit'"
			 class="bbn-grid-fields bbn-padded"
	>
		<label><?= _('Type of articles') ?></label>
		<bbn-dropdown :source="typesNote"
									bbn-model="source.noteType"
									sourceValue="id"
		/>
		
		<label><?= _('Ordered by') ?></label>
		<bbn-dropdown :source="orderFields"
									bbn-model="source.order"
									sourceValue="value"
		/>
		
		<label><?= _('Height') ?> (px)</label>
		<bbn-range bbn-model="source.style.height"
							 :min="10"
							 :max="410"
							 :step="10"
							 :show-reset="false"
							 :show-numeric="true"
							 unit="px"
							 />

		<label><?= _('Max slide in line') ?></label>
		<bbn-numeric bbn-model="source.max"
								 :step="1"
								 :min="1"
								 :default="1"
								 :nullable="false"
								 :max="5"
		/>
		
		<label><?= _('Min slide in line') ?></label>
		<bbn-numeric bbn-model="source.max"
								 :step="1"
								 :min="1"
								 :default="1"
								 :max="5"
								 :nullable="false"
		/>
		
		<label><?= _('Limits') ?></label>
		<bbn-numeric bbn-model="source.limit"
								 :step="10"
								 :min="10"
								 :nullable="false"
		/>
	</div>
	<div bbn-else class="bbn-w-100" :style="source.style">
		<bbn-slideshow :checkbox="false"
									 :dimension-preview="45"
									 :auto-play="false"
									 :arrows="{left: 'nf nf-fa-angle_left', right: 'nf nf-fa-angle_right'}"
									 :auto-hide-ctrl="true"
									 :loop="true"
									 :full-slide="true"
									 :initial-slide="0"
									 :source="sliderSource"
									 bbn-if="sliderSource && sliderSource.length"
		/>
	</div>
</div>