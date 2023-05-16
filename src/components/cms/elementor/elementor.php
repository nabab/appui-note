<!-- HTML Document -->
<div class="appui-note-cms-elementor bbn-overlay"
     @click="unselect"
     @dragend="onDragEnd">
  <div class="bbn-padding bbn-w-100">
    <template v-if="source.length">
      <div v-for="(cfg, i) in source"
           class="bbn-w-100">
        <appui-note-cms-elementor-guide :visible="isDragging"
                                        v-droppable.data="{data: {index: i}}"
                                        @drop.prevent="onDrop"/>
        <appui-note-cms-container v-if="cfg.type === 'container'"
                                  :source="cfg"
                                  :ref="'block' + i"
                                  :selectable="!preview"
                                  :overable="!preview"
                                  :index="i"
                                  :selected="currentEditingKey === cfg._elementor.key"
                                  :itemSelected="currentEditingKey"
                                  @click.stop="selectBlock(cfg._elementor.key, cfg)"
                                  @selectblock="selectBlock"
                                  :key="cfg._elementor.key"
                                  v-draggable.data.mode="getDraggableData(i, cfg, 'cmsContainer')"
                                  @dragstart="currentDragging = true"
                                  @dragend="onDragEnd"
                                  :dragging="isDragging"/>
        <appui-note-cms-block v-else
                              :source="cfg"
                              :ref="'block' + i"
                              :selectable="!preview"
                              :overable="!preview"
                              :selected="currentEditingKey === cfg._elementor.key"
                              @click.stop="selectBlock(cfg._elementor.key, cfg)"
                              :data-index="i"
                              v-draggable.data.mode="getDraggableData(i, cfg, 'cmsBlock')"
                              @dragstart="currentDragging = true"
                              @dragend="onDragEnd"
                              :key="cfg._elementor.key"/>
      </div>
      <appui-note-cms-elementor-guide :visible="isDragging"
                                      :force="isDragging && !source.length"
                                      v-droppable.data="{data: {index: source.length}}"
                                      @drop.prevent="onDrop"/>
    </template>
    <div v-if="dragging"
         class="bbn-w-100 bbn-lpadded bbn-middle bbn-upper"
         v-text="!!source.length ? _('Drop the widget here to place it at the bottom of the page') : _('Drop the widget here')"
         v-droppable.data="{data: {index: source.length}}"
         @drop.prevent="onDrop"
         style="border: 2px dashed var(--alt-background);"/>
  </div>
  <div ref="divider"
       class="appui-note-cms-elementor-divider"/>
</div>
