<!-- HTML Document -->

<div :class="[componentClass, 'component-container', 'bbn-block-html']">
  <bbn-rte v-if="isEditor"
           v-model="source.content"/>
  <div v-else
	     v-html="source.content"/>
</div>