<div :class="[
        componentClass,
        'bbn-block',
        {
          'bbn-w-100': !isVertical,
          'bbn-h-100': !!isVertical,
          '<?= $componentName ?>-over': overable && over,
          '<?= $componentName ?>-editable': overable,
          '<?= $componentName ?>-selected': selectable && selected
        }
      ]"
      tabindex="0"
      @mouseenter="over = true"
      @mouseleave="over = false"
     	@click="$emit('click', $event)"
      @dragstart="e => $emit('dragstart', e)"
      @dragend="e => $emit('dragend', e)"
      @beforedrop="e => $emit('beforedrop', e)">
  <div :class="['<?= $componentName ?>-component', {
         'bbn-w-100': !isVertical,
         'bbn-h-100': !!isVertical,
         '<?= $componentName ?>-selectable': selectable,
         'bbn-p': selectable,
         '<?= $componentName ?>-selected': selectable && selected
       }]">
    <template v-if="mode === 'read'">
      <div v-if="!selectable || !!source.items?.length"
           class="bbn-grid"
           :style="gridStyle"
           key="containerGrid">
        <template v-for="(item, i) in source.items">
          <appui-note-cms-elementor-guide v-if="overable"
                                          :visible="isDragging"
                                          v-droppable.data="{data: {index: i}}"
                                          @drop.prevent.stop="onDrop"
                                          :vertical="!isVertical"/>
          <div @mouseenter="overItem = i"
               @mouseleave="overItem = -1"
               :class="{
                 'bbn-vmargin': selectable && !isVertical,
                 'bbn-hmargin': selectable && isVertical
               }">
            <div class="bbn-100">
              <appui-note-cms-container v-if="item.type === 'container'"
                                        :source="item"
                                        :selectable="selectable"
                                        :overable="selectable"
                                        :index="i"
                                        :selected="itemSelected === item._elementor?.key"
                                        :itemSelected="itemSelected"
                                        @click.stop="selectBlock(item._elementor.key, item, $event)"
                                        @selectblock="selectBlock"
                                        :key="overable ? item._elementor.key : i"
                                        v-draggable.data.mode="getDraggableData(i, item, 'cmsContainer')"
                                        @dragstart="onDragStart"
                                        @dragend="onDragEnd"
                                        :dragging="isDragging"/>
              <appui-note-cms-block v-else
                                    @click="selectBlock(item._elementor.key, item, $event)"
                                    @config-init="configInit"
                                    :path="path"
                                    :editable="editable"
                                    :selectable="selectable"
                                    :selected="itemSelected === item._elementor?.key"
                                    :overable="overable"
                                    :mode="mode"
                                    :source="item"
                                    :data-index="index"
                                    :data-container-index="i"
                                    v-draggable.data.mode="getDraggableData(i, item, 'cmsContainerBlock')"
                                    @dragstart="onDragStart"
                                    @dragend="onDragEnd"
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
                                        v-droppable.data="{data: {index: source.items.length}}"
                                        @drop.prevent.stop="onDrop"
                                        :vertical="!isVertical"/>
      </div>
      <div v-else-if="selectable"
           class="bbn-w-100 bbn-lpadded bbn-middle bbn-upper"
           v-text="_('Drop a widget here')"
           v-droppable.data="{data: {index: 0}}"
           @drop.prevent.stop="onDrop"
           key="containerDropArea"/>
      <div v-if="overable && (mode === 'read')"
           :class="['bbn-top-right', 'bbn-xspadding', {'bbn-hidden': !over}]">
        <bbn-button icon="nf nf-fa-plus"
                    title="<?= _("Click here to add a new item on this line") ?>"
                    :notext="true"
                    @click="addBlock"/>
      </div>
    </template>
    <div v-else
         class="bbn-grid-fields bbn-w-100">
      <label v-text="_('Orientation')"/>
      <bbn-radiobuttons v-model="source.orientation"
                        :source="[{
                          text: _('Horizontal'),
                          value: 'horizontal'
                        }, {
                          text: _('Vertical'),
                          value: 'vertical'
                        }]"/>
      <label v-text="_('Horizontal Alignment')"/>
      <bbn-radiobuttons v-model="source.align"
                        :source="[{
                          text: _('Start'),
                          value: 'start'
                        }, {
                          text: _('Center'),
                          value: 'center'
                        }, {
                          text: _('End'),
                          value: 'end'
                        }, {
                          text: _('Stretch'),
                          value: 'stretch'
                        }]"/>
      <label v-text="_('Vertical Alignment')"/>
      <bbn-radiobuttons v-model="source.valign"
                        :source="[{
                          text: _('Start'),
                          value: 'start'
                        }, {
                          text: _('Center'),
                          value: 'center'
                        }, {
                          text: _('End'),
                          value: 'end'
                        }, {
                          text: _('Stretch'),
                          value: 'stretch'
                        }]"/>
    </div>
  </div>
</div>
