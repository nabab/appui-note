<!-- HTML Document -->
<div class="appui-note-cms-elementor bbn-overlay"
     @drop="ev => $emit('drop', ev)"
     @dragoverdroppable="onDrag"
     @dragstart="dragStart"
     @click="unselect">
  <div class="bbn-padding bbn-w-100">
    <div v-for="(cfg, i) in source"
         class="bbn-w-100 bbn-bottom-margin">
      <appui-note-cms-container v-if="cfg.type === 'container'"
                                :source="cfg"
                                :ref="'block' + i"
                                :selectable="!preview"
                                :overable="!preview"
                                :index="i"
                                :selected="currentEditedIndex === i"
                                :itemSelected="indexInContainer"
                                @click="selectContainer"
                                />
      <appui-note-cms-block v-else
                            :source="cfg"
                            :ref="'block' + i"
                            :selectable="!preview"
                            :overable="!preview"
                            :selected="currentEditedIndex === i"
                            @click.stop="selectBlock(i, cfg)"
                            :data-index="i"
                            v-draggable.data.mode="{data: cfg, mode: 'self'}"
                            />

    </div>
  </div>
  <div ref="divider"
       class="appui-note-cms-elementor-divider">
  </div>
  <div ref="guide"
       class="appui-note-cms-elementor-guide">
    <div class="bbn-w-100">
    </div>
  </div>
</div>
