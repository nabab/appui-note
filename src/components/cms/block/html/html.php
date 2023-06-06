<!-- HTML Document -->

<div :class="[componentClass, 'component-container', 'bbn-block-html']">
  <bbn-rte v-if="isEditor"
           v-model="source.content"/>
  <div v-else-if="!source.content && $parent.selectable"
        class="bbn-alt-background bbn-middle bbn-lpadded"
        style="overflow: hidden">
    <i class="bbn-xxxxl nf nf-fa-html5"/>
  </div>
  <div v-else
	     v-html="source.content"
       :style="style"/>
</div>