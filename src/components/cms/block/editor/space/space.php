<!-- HTML Document -->

<div class="component-container" :style="style">
  <div :style="style" class="block-space-edit">
    <bbn-cursor v-model="source.style.height" 
                unit="px"
                :min="0"
                :step="50"
                ></bbn-cursor>
  </div>
</div>