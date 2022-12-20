<!-- HTML Document -->
<div class="bbn-overlay"
     @drop="ev => $emit('drop', ev)"
     @dragoverdroppable="onDrag">
  <div class="bbn-padding bbn-w-100"
       @click="currentEdited = -1">
    <div v-for="(cfg, i) in source"
         class="bbn-w-100 bbn-bottom-padding">
      <appui-note-cms-block-container v-if="cfg.type === 'container'"
                                      :source="cfg"
                                      :ref="'block' + i"
                                      :selectable="true"
                                      :overable="true"
                                      :selected="currentEdited === i"
                                      @select="updateSelected"
                                      @click.stop="changeEdited(i)"/>
      <appui-note-cms-block v-else
                            :source="cfg"
                            :ref="'block' + i"
                            :selectable="true"
                            :overable="true"
                            :selected="currentEdited === i"
                            @click.stop="changeEdited(i)"/>
    </div>
  </div>
</div>
