<!-- HTML Document -->

<div :class="[componentClass, 'bbn-w-100']">
  <div v-if="mode === 'edit'"
       class="bbn-grid-fields">
    <label><?= _("Space") ?></label>
    <div class="bbn-flex-width bbn-vmiddle">
      <bbn-cursor v-model="currentSize"
                  :min="10"
                  :max="2000" 
                  :step="10"
                  class="bbn-flex-fill bbn-right-sspace"
                  :unit="currentUnit"/>
      <bbn-dropdown v-model="currentUnit"
                    :source="units"
                    style="width: 6em"/>
    </div>
  </div>
  <div v-else
       :style="{height: source.size}">
    &nbsp;
  </div>
</div>