<!-- HTML Document -->

<div @click="$emit('click', $event)"
     :class="[
             componentClass,
             '<?= $componentName ?>-component-container', 'bbn-block-title',
             {'has-hr': source.hr},
             alignClass
             ]">
  <hr v-if="['both', 'top', true].includes(source.hr)">
  <component :is="tag"
             :style="style"
             v-html="source.content">
  </component>
  <hr v-if="['both', 'bottom', true].includes(source.hr)">
</div>