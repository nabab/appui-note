<!-- HTML Document -->

<div @click="$emit('click', $event)"
     :class="['component-container', 'bbn-block-title', {'has-hr': source.hr}, alignClass]">
  <hr v-if="source.hr">
  <component :is="tag"
             v-html="source.content">
  </component>
  <hr v-if="source.hr">
</div>