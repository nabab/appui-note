<div :class="[
        componentClass,
        'bbn-w-100',
        'bbn-block',
        {
          '<?= $componentName ?>-over': overable && over,
          '<?= $componentName ?>-editable': overable,
          '<?= $componentName ?>-selected': selected
        }
      ]"
      tabindex="0"
      @mouseenter="over = true"
      @mouseleave="over = false"
     	@click="$emit('click', $event)"
      @dragstart="e => $emit('dragstart', e)"
      @dragend="e => $emit('dragend', e)"
      @beforedrop="e => $emit('beforedrop', e)">
  <div :class="['bbn-w-100', '<?= $componentName ?>-component', {
         '<?= $componentName ?>-selectable': selectable,
         'bbn-p': selectable,
         '<?= $componentName ?>-selected': selectable && selected
       }]">
    <template v-if="mode === 'read'">
      <div v-if="source.items?.length"
           class="bbn-grid"
           :style="gridStyle">
        <template v-for="(item, i) in source.items">
          <appui-note-cms-elementor-guide v-if="overable"
                                          :visible="isDragging"
                                          v-droppable.data="{data: {index: i}}"
                                          @drop.prevent="onDrop"
                                          :vertical="!isMobile"/>
          <div @mouseenter="overItem = i"
               @mouseleave="overItem = -1"
               :class="{'bbn-vmargin': selectable}">
            <div class="bbn-100">
              <appui-note-cms-block @click="selectBlock(item._elementor.key, item, $event)"
                                    @config-init="configInit"
                                    :path="path"
                                    :editable="editable"
                                    :selectable="selectable"
                                    :selected="itemSelected === item?._elementor?.key"
                                    :overable="overable"
                                    :mode="mode"
                                    :source="item"
                                    :data-index="index"
                                    :data-container-index="i"
                                    v-draggable.data.mode="overable ? {data: {type: 'cmsContainerBlock', index: i, source: item}, mode: 'clone'} : false"
                                    @dragstart="e => $emit('dragstart', e)"
                                    @dragend="e => $emit('dragend', e)"
                                    :key="overable ? item._elementor.key : i"/>
              <div v-if="overable && (mode === 'read')"
                   :class="['bbn-bottom-right', 'bbn-xspadding', {'bbn-hidden': overItem !== i}]">
                <bbn-button icon="nf nf-fa-minus"
                            title="<?= _("Click here to add a new item on this line") ?>"
                            :notext="true"
                            @click="removeBlock(i)"/>
              </div>
            </div>
          </div>
        </template>
        <appui-note-cms-elementor-guide v-if="overable"
                                        :visible="isDragging"
                                        :force="isDragging && !source.items.length"
                                        v-droppable.data="{data: {index: source.items.length}}"
                                        @drop.prevent="onDrop"
                                        :vertical="!isMobile"/>
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
    </template>
    <div v-else>
      aaaa
    </div>
  </div>
</div>
