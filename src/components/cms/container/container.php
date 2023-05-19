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
      @beforedrop="e => $emit('beforedrop', e)"
      @drop="e => $emit('drop', e)">
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
                                        :item-selected="itemSelected"
                                        @click.stop="selectBlock(item._elementor.key, item, _self, $event)"
                                        @selectblock="selectBlock"
                                        :key="overable ? item._elementor.key : i"
                                        v-draggable.data.mode="getDraggableData(i, item, 'cmsContainer')"
                                        @dragstart="onDragStart"
                                        @dragend="onDragEnd"
                                        :dragging="isDragging"/>
              <appui-note-cms-block v-else
                                    @click="selectBlock(item._elementor.key, item, _self, $event)"
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
                                    v-droppable.data="{data: {index: i, replace: true, source: item}}"
                                    @drop.prevent="onDrop"
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
    </template>
    <div v-else
         class="appui-note-cms-container-editor bbn-grid-fields bbn-w-100">
      <label v-text="_('Orientation')"/>
      <bbn-radiobuttons v-model="source.orientation"
                        :notext="true"
                        :source="[{
                          text: _('Horizontal'),
                          value: 'horizontal',
                          icon: 'nf nf-cod-split_horizontal'
                        }, {
                          text: _('Vertical'),
                          value: 'vertical',
                          icon: 'nf nf-cod-split_vertical'
                        }]"/>
      <label v-text="_('Horizontal Alignment')"/>
      <bbn-radiobuttons v-model="source.align"
                        :notext="true"
                        :source="[{
                          text: _('None'),
                          value: '',
                          icon: 'nf nf-md-cancel'
                        }, {
                          text: _('Start'),
                          value: 'flex-start',
                          icon: 'nf nf-md-align_horizontal_left'
                        }, {
                          text: _('Center'),
                          value: 'center',
                          icon: 'nf nf-md-align_horizontal_center'
                        }, {
                          text: _('End'),
                          value: 'flex-end',
                          icon: 'nf nf-md-align_horizontal_right'
                        }, {
                          text: _('Space between'),
                          value: 'space-between',
                          icon: 'nf nf-md-align_horizontal_distribute'
                        }, {
                          text: _('Space around'),
                          value: 'space-around',
                          icon: 'nf nf-md-align_horizontal_distribute'
                        }, {
                          text: _('Space evenly'),
                          value: 'space-evenly',
                          icon: 'nf nf-md-align_horizontal_distribute'
                        }]"
                        style="flex-wrap: wrap"/>
      <label v-text="_('Vertical Alignment')"/>
      <bbn-radiobuttons v-model="source.valign"
                        :notext="true"
                        :source="[{
                          text: _('None'),
                          value: '',
                          icon: 'nf nf-md-cancel'
                        }, {
                          text: _('Start'),
                          value: 'flex-start',
                          icon: 'nf nf-md-align_vertical_top'
                        }, {
                          text: _('Center'),
                          value: 'center',
                          icon: 'nf nf-md-align_vertical_center'
                        }, {
                          text: _('End'),
                          value: 'flex-end',
                          icon: 'nf nf-md-align_vertical_bottom'
                        }, {
                          text: _('Stretch'),
                          value: 'stretch',
                          icon: 'nf nf-md-align_vertical_distribute'
                        }]"/>
      <template v-if="source.items?.length && Object.keys(gridLayout).length">
        <label v-text="_('Layout')"/>
        <div>
          <div v-for="(it, i) in source.items"
               :class="{'bbn-bottom-space': !!source.items[i+1]}">
            <div class="bbn-bottom-sspace">
              {{i + 1}} - {{getWidgetName(it.type)}}
            </div>
            <bbn-radiobuttons v-model="gridLayout[i]"
                              class="bbn-bottom-sspace bbn-s"
                              :source="[{
                                text: 'AUTO',
                                title: _('Auto'),
                                value: 'auto'
                              }, {
                                text: 'MAX',
                                title: _('Max content'),
                                value: 'max-content'
                              }, {
                                text: 'FR',
                                title: _('Fraction'),
                                value: '1fr'
                              }]"/>
            <bbn-input v-model="gridLayout[i]"
                       style="width: 100%"/>
          </div>
        </div>
      </template>
    </div>
  </div>
</div>
