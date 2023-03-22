<!-- HTML Document -->

<div :class="[componentClass, 'component-container', 'bbn-block-html']">
  <bbn-rte v-if="isEditor"
           v-model="currentSource.content"/>
  <div v-else
	     v-html="currentSource.content"
       :style="style"/>
</div>