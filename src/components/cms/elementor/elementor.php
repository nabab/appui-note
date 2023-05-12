<!-- HTML Document -->
<div class="appui-note-cms-elementor bbn-overlay"
     @click="unselect"
     @dragend="onDragEnd">
  <div class="bbn-padding bbn-w-100">
    <template v-if="source.length">
      <div v-for="(cfg, i) in source"
           class="bbn-w-100">
        <guide :visible="isDragging"
               v-droppable.data="{data: {index: i}}"
               @drop.prevent="onDrop"/>
        <appui-note-cms-container v-if="cfg.type === 'container'"
                                  :source="cfg"
                                  :ref="'block' + i"
                                  :selectable="!preview"
                                  :overable="!preview"
                                  :index="i"
                                  :selected="currentEditingKey === cfg._elementor.key"
                                  :itemSelected="indexInContainer"
                                  @click="selectContainer(cfg._elementor.key, cfg)"
                                  :key="cfg._elementor.key"/>
        <appui-note-cms-block v-else
                              :source="cfg"
                              :ref="'block' + i"
                              :selectable="!preview"
                              :overable="!preview"
                              :selected="currentEditingKey === cfg._elementor.key"
                              @click.stop="selectBlock(cfg._elementor.key, cfg)"
                              :data-index="i"
                              v-draggable.data.mode="{data: {type: 'elementor', index: i, source: cfg}, mode: 'clone'}"
                              @dragstart="currentDragging = true"
                              @dragend="onDragEnd"
                              :key="cfg._elementor.key"/>
      </div>
      <guide :visible="isDragging"
             :force="isDragging && !source.length"
             v-droppable.data="{data: {index: source.length}}"
             @drop.prevent="onDrop"/>
    </template>
    <div v-if="dragging"
         class="bbn-w-100-bbn-lpadded bbn-middle bbn-upper"
         v-text="!!source.length ? _('Drop the widget here to place it at the bottom of the page') : _('Drop the widget here')"
         v-droppable.data="{data: {index: source.length}}"
         @drop.prevent="onDrop"
         style="height: 10rem; border: 2px dashed var(--alt-background);"/>
  </div>
  <div ref="divider"
       class="appui-note-cms-elementor-divider"/>
</div>
