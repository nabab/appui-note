<!-- HTML Document -->

<div :class="[componentClass, 'bbn-w-100']">
  <div v-if="mode === 'edit'"
       class="bbn-grid-fields">
    <label><?= _("Space") ?></label>
    <bbn-range v-model="source.size"
						   :max="2000" 
               :show-reset="false"
               :show-numeric="true"
               :show-units="true"
               unit="em"/>
  </div>
  <div v-else
       :style="{height: source.size}">
    &nbsp;
  </div>
</div>