<!-- HTML Document -->
<div class="appui-note-cms-elementor bbn-overlay"
     @drop="ev => $emit('drop', ev)"
     @dragoverdroppable="onDrag"
     @dragstart="dragStart">
  <div class="bbn-padding bbn-w-100"
       @click="currentEdited = -1">
    <div v-for="(cfg, i) in source"
         class="bbn-w-100 bbn-bottom-margin">
      <appui-note-cms-container v-if="cfg.type === 'container'"
                                :source="cfg.source"
                                :ref="'block' + i"
                                :selectable="!preview"
                                :overable="!preview"
                                :index="i"
                                :selected="currentEdited === i"
                                @click="changeEditedContainer(cfg)"
                                />
      <appui-note-cms-block v-else
                            :source="cfg"
                            :ref="'block' + i"
                            :selectable="!preview"
                            :overable="!preview"
                            :selected="currentEdited === i"
                            @click="changeEdited"
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
    <div class="bbn-w-100"
         style="height: 0.3em;">
    </div>
  </div>
</div>
