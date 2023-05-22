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
                                  :selected="itemSelected === cfg._elementor.key"
                                  :itemSelected="itemSelected"
                                  @click.stop="selectBlock(cfg._elementor.key, cfg, editor)"
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
                              :selected="itemSelected === cfg._elementor.key"
                              @click.stop="selectBlock(cfg._elementor.key, cfg, editor)"
                              :data-index="i"
                              v-draggable.data.mode="getDraggableData(i, cfg, 'cmsBlock')"
                              @dragstart="currentDragging = true"
                              @dragend="onDragEnd"
                              v-droppable.data="{data: {index: i, replace: true, source: cfg}}"
                              @drop.prevent="onDrop"
                              :key="cfg._elementor.key"/>
      </div>
      <appui-note-cms-elementor-guide :visible="isDragging"
                                      :force="isDragging && !source.length"
                                      v-droppable.data="{data: {index: source.length}}"
                                      @drop.prevent="onDrop"/>
    </template>
    <div v-if="dragging"
         class="appui-note-cms-elementor-droparea bbn-w-100 bbn-lpadded bbn-middle bbn-upper"
         v-droppable.data="{data: {index: source.length}}"
         @drop.prevent="onDrop"
         key="elementorDropArea">
      <i class="nf nf-fa-plus bbn-xl"/>
    </div>
  </div>
  <div ref="divider"
       class="appui-note-cms-elementor-divider"/>
</div>
