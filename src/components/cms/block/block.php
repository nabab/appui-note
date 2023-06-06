<div :class="[
        componentClass,
        currentClass,
        {
          '<?= $componentName ?>-over': overable && over,
          '<?= $componentName ?>-selected': selected,
       	}
      ]"
      tabindex="0"
     	@click="onClick"
      @mouseenter="over = true"
      @mouseleave="over = false"
      @dragstart.stop="e => $emit('dragstart', e)"
      @dragend="e => $emit('dragend', e)"
      @beforedrop="e => $emit('beforedrop', e)"
      @drop="e => $emit('drop', e)">
  <component v-if="ready"
             @configinit="configInit"
             :is="currentComponent"
             :cfg="cfg"
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
