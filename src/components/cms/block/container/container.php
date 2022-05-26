<div :class="[
        componentClass,
        'bbn-w-100',
        'bbn-block',
        {
          '<?= $componentName ?>-over': overable && over,
          '<?= $componentName ?>-editable': overable
        }
      ]"
      tabindex="0"
     	@click="$emit('click', $event)"
      @mouseenter="over = true"
      @mouseleave="over = false">
  <div :class="[
                 'bbn-w-100',
                 '<?= $componentName ?>-component',
                 {
                 '<?= $componentName ?>-selectable': selectable,
                 '<?= $componentName ?>-selected': selectable && selected
                 },
               ]">
    <div v-if="source.items.length"
         class="bbn-grid"
         :style="{gridTemplateCols: 'repeat(' + (source.items.length + 1) + ', 1fr)'}">
      <appui-note-cms-block v-for="(item, i) in source.items"
                            @click="currentItemSelected = i"
                            :key="i"
                            :path="path"
                            :editable="editable"
                            :selectable="selectable"
                            :selected="currentItemSelected === i"
                            :overable="overable"
                            :mode="mode"
                            :source="item"/>
    </div>
    <h3 v-else
        class="bbn-p"
        @click="addBlock">
      <?= _("Click here to add a new item on this line") ?>
    </h3>
    <div v-if="overable && (mode === 'read')"
         class="bbn-spadding <?= $componentName ?>-icons">
      <bbn-button class="bbn-xl"
                  icon="nf nf-fa-plus"
                  title="<?= _("Click here to add a new item on this line") ?>"
                  @click="addBlock"/>
    </div>
  </div>
</div>
