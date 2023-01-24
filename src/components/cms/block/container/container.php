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
    <div v-if="source.items?.length"
         class="bbn-grid"
         :style="gridStyle">
      <div v-for="(item, i) in source.items"
           @mouseenter="overItem = i"
           @mouseleave="overItem = -1"
           :key="i">
        <div class="bbn-100">
          <appui-note-cms-block @click="changeEditedContainer(item)"
                                :path="path"
                                :editable="editable"
                                :selectable="selectable"
                                :selected="currentItemSelected === i"
                                :overable="overable"
                                :mode="mode"
                                :source="item"
                                :data-index="index"
                                :data-container-index="i"
                                v-draggable.data.mode="{data: item, mode: 'self'}"/>
          <div v-if="overable && (mode === 'read')"
               :class="['bbn-bottom-right', 'bbn-xspadding', {'bbn-hidden': overItem !== i}]">
            <bbn-button icon="nf nf-fa-minus"
                        title="<?= _("Click here to add a new item on this line") ?>"
                        :notext="true"
                        @click="removeBlock(i)"/>
          </div>
        </div>
      </div>
    </div>
    <h3 v-else
        class="bbn-p"
        @click="addBlock">
      <?= _("Click here to add a new item on this line") ?>
    </h3>
    <div v-if="overable && (mode === 'read')"
         :class="['bbn-top-right', 'bbn-xspadding', {'bbn-hidden': !over}]">
      <bbn-button icon="nf nf-fa-plus"
                  title="<?= _("Click here to add a new item on this line") ?>"
                  :notext="true"
                  @click="addBlock"/>
    </div>
  </div>
</div>
