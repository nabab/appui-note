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
  <!--<div class="bbn-overlay bbn-flex-height">
    <div v-if="currentEdited > -1"
         class="bbn-header bbn-padded bbn-vmiddle bbn-m bbn-b bbn-flex-width">
      <div class="bbn-middle bbn-flex-fill"
           v-if="editedSource">
        <bbn-dropdown :source="types"
                      v-model="editedSource.type"/>
      </div>
      <div class="bbn-middle bbn-nowrap bbn-flex-fill">
        <?= _("Position of the block") ?>
        <span class="bbn-left-space"
              v-text="currentEdited + 1"/>
        <bbn-button class="bbn-left-space"
                    :notext="true"
                    @click="deleteCurrentSelected"
                    text="<?= _("Delete this block") ?>"
                    icon="nf nf-fa-trash"/>
      </div>
    </div>
  </div>-->
</div>
