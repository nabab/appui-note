<!-- HTML Document -->
<div class="bbn-overlay"
     @drop="ev => $emit('drop', ev)"
     @dragoverdroppable="onDrag">
  <div class="bbn-padding bbn-w-100"
       @click="currentEdited = -1">
    <div v-for="(cfg, i) in source"
         class="bbn-w-100 bbn-bottom-margin">
      <appui-note-cms-block-container v-if="cfg.type === 'container'"
                                      :source="cfg.source"
                                      :ref="'block' + i"
                                      :selectable="true"
                                      :overable="true"
                                      :selected="currentEdited === i"
                                      @select="updateSelected"
                                      @click.stop="changeEdited(i)"
                                      v-draggable.data.mode="{data: {type: cfg.type, inside: true, index: i}, mode: 'self'}"/>
      <appui-note-cms-block v-else
                            :source="cfg"
                            :ref="'block' + i"
                            :selectable="true"
                            :overable="true"
                            :selected="currentEdited === i"
                            @click.stop="changeEdited(i)"
                            v-draggable.data.mode="{data: {type: cfg.type, inside: true, index: i}, mode: 'self'}"/>

    </div>
  </div>
  <div ref="divider"
         class="bbn-w-50"
         style="display: none; position: absolute; border: 1px dashed; pointer-events: none;">
    </div>
  <div ref="guide"
       class="guide bbn-w-100"
       style="height: 20px; display: none; justify-content: center; align-items: center; position: absolute; left: 0;">
    <div class="bbn-w-100 bbn-h-10" style="border: 1px dashed; pointer-events: none;"/>
  </div>
</div>
