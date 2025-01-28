<!-- HTML Document -->
<div class="appui-note-cms-elementor bbn-w-100"
     @click="unselect"
     @dragend="onDragEnd">
  <div class="bbn-padding bbn-w-100">
    <template bbn-if="source.length">
      <div bbn-for="(cfg, i) in source"
           class="bbn-w-100">
        <appui-note-cms-elementor-guide bbn-show="!preview"
                                        :visible="isDragging"
                                        bbn-droppable.data="preview || !isDragging ? false : {data: {index: i}}"
                                        @drop.prevent.stop="onDrop"/>
        <appui-note-cms-container bbn-if="cfg.type === 'container'"
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
                                  bbn-draggable.data.mode="getDraggableData(i, cfg, 'cmsContainer')"
                                  @dragstart="currentDragging = true"
                                  @dragend="onDragEnd"
                                  :dragging="isDragging"/>
        <appui-note-cms-block bbn-else
                              :source="cfg"
                              :ref="'block' + i"
                              :selectable="!preview"
                              :overable="!preview"
                              :selected="itemSelected === cfg._elementor.key"
                              @click.stop="selectBlock(cfg._elementor.key, cfg, editor)"
                              :data-index="i"
                              bbn-draggable.data.mode="getDraggableData(i, cfg, 'cmsBlock')"
                              @dragstart="currentDragging = true"
                              @dragend="onDragEnd"
                              bbn-droppable.data="preview || !isDragging ? false : {data: {index: i, replace: true, source: cfg}}"
                              @drop.prevent.stop="onDrop"
                              :key="cfg._elementor.key"/>
      </div>
      <appui-note-cms-elementor-guide bbn-show="!preview"
                                      :visible="isDragging"
                                      :force="isDragging && !source.length"
                                      bbn-droppable.data="preview || !isDragging ? false : {data: {index: source.length}}"
                                      @drop.prevent.stop="onDrop"/>
    </template>
    <div bbn-if="dragging"
         class="appui-note-cms-elementor-droparea bbn-w-100 bbn-lpadding bbn-middle bbn-upper"
         bbn-droppable.data="{data: {index: source.length}}"
         @drop.prevent.stop="onDrop"
         @dragoverdroppable="mirko">
      <i class="nf nf-fa-plus bbn-xl"/>
    </div>
  </div>
  <div ref="divider"
       class="appui-note-cms-elementor-divider"/>
</div>
