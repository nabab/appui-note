<!-- HTML Document -->

<div :class="[componentClass, 'bbn-w-100']">
  <div bbn-if="mode === 'edit'"
       class="bbn-grid-fields">
    <label><?= _("Space") ?></label>
    <bbn-range bbn-model="source.size"
						   :max="2000" 
               :show-reset="false"
               :show-numeric="true"
               :show-units="true"
               unit="em"/>
  </div>
  <div bbn-else
       :style="{height: source.size}">
    &nbsp;
  </div>
</div>