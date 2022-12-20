<!-- HTML Document -->
<div class="bbn-overlay"
     @drop="ev => $emit('drop', ev)"
     @dragoverdroppable="onDrag">
  <div class="bbn-padding bbn-w-100"
       @click="currentEdited = -1">
    <div v-if="showGuide"
         class="guide bbn-w-100"
         style="height: 20px; border-top: 3px dashed;">
    </div>
    <div v-for="(cfg, i) in source"
         class="bbn-w-100 bbn-bottom-margin">
      <div v-if="showGuide && position == i && position != 0"
           class="guide bbn-w-100"
           style="height: 20px; border-top: 3px dashed;">
      </div>
      <appui-note-cms-block-container v-if="cfg.type === 'container'"
                                      :source="cfg"
                                      :ref="'block' + i"
                                      :selectable="true"
                                      :overable="true"
                                      :selected="currentEdited === i"
                                      @select="updateSelected"
                                      @click.stop="changeEdited(i)"
                                      v-draggable.data.mode="{data: {type: cfg.type}, mode: 'self'}"/>
      <appui-note-cms-block v-else
                            :source="cfg"
                            :ref="'block' + i"
                            :selectable="true"
                            :overable="true"
                            :selected="currentEdited === i"
                            @click.stop="changeEdited(i)"
                            v-draggable.data.mode="{data: {type: cfg.type}, mode: 'self'}"/>
    </div>
    <div v-if="showGuide"
         class="guide bbn-w-100"
         style="height: 20px; border-top: 3px dashed;">
    </div>
  </div>
</div>
