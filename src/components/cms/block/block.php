<div :class="[
        componentClass,
        'bbn-w-100',
        'bbn-block',
        {'<?= $componentName ?>-over': overable && over}
      ]"
      tabindex="0"
     	@click="$emit('click', $event)"
      @mouseenter="over = true"
      @mouseleave="over = false">
  <component v-if="ready"
             :is="currentComponent"
             ref="component"
             :mode="mode"
             :source="source"
             :class="[
                       '<?= $componentName ?>-component',
                       {
                        '<?= $componentName ?>-selectable': selectable,
                        '<?= $componentName ?>-selected': selectable && selected
                       }
                     ]"/>
  <div v-if="selectable"
       class="bbn-overlay bbn-p"/>
  <div v-if="editable"
       class="<?= $componentName ?>-icons bbn-vmiddle">
    <div class="bbn-nowrap bbn-block">
      <i class="bbn-p nf nf-fa-edit inline bbn-xxlarge bbn-white bbn-hxsmargin"
          @click="editMode"
          v-if="isAdmin && editing && !edit"></i>
      <i class="bbn-p nf nf-fa-check inline bbn-xxlarge bbn-white bbn-hxsmargin"
          @click="editBlock"
          v-if="changed"></i>
      <i class="bbn-p nf nf-fa-close inline bbn-xxlarge bbn-white bbn-hxsmargin"
          @click="cancelEdit"
          v-if="changed"></i>
    </div>
    <div class="bbn-overlay bbn-modal"></div>
    <div class="bbn-overlay bbn-vmiddle">
      <div class="bbn-nowrap bbn-block">
        <i class="bbn-p nf nf-fa-edit inline bbn-xxlarge bbn-white bbn-hxsmargin"
           @click="editMode"
           v-if="isAdmin && editing && !edit"></i>
        <i class="bbn-p nf nf-fa-check inline bbn-xxlarge bbn-white bbn-hxsmargin"
           @click="editBlock"
           v-if="changed"></i>
        <i class="bbn-p nf nf-fa-close inline bbn-xxlarge bbn-white bbn-hxsmargin"
           @click="cancelEdit"
           v-if="changed"></i>
      </div>
    </div>
  </div>
</div>
