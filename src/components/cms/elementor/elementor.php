<!-- HTML Document -->
<div class="bbn-overlay"
     @drop="ev => $emit('drop', ev)"
     @dragoverdroppable="onDrag"
     @dragstart="dragStart">
  <div class="bbn-padding bbn-w-100"
       @click="currentEdited = -1">
    <div v-for="(cfg, i) in source"
         class="bbn-w-100 bbn-bottom-margin">
      <appui-note-cms-block-container v-if="cfg.type === 'container'"
                                      :source="cfg.source"
                                      :ref="'block' + i"
                                      :selectable="true"
                                      :overable="true"
                                      :index="i"
                                      :selected="currentEdited === i"
                                      @click="changeEditedContainer"
                                      />
      <appui-note-cms-block v-else
                            :source="cfg"
                            :ref="'block' + i"
                            :selectable="true"
                            :overable="true"
                            :selected="currentEdited === i"
                            @click="changeEdited"
                            :data-index="i"
                            v-draggable.data.mode="{data: cfg, mode: 'self'}"
                            />

    </div>
  </div>
  <div ref="divider"
         class="bbn-w-50"
         style="display: none; position: absolute; border: 1px dashed; pointer-events: none;">
    </div>
  <div ref="guide"
       class="guide bbn-w-100 bbn-bg-gray"
       style="height: 20px; display: none; justify-content: center; align-items: center; position: absolute; left: 0;">
    <div class="bbn-w-100 bbn-h-10" style="border: 1px dashed; pointer-events: none;"/>
  </div>
</div>
