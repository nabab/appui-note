<!-- HTML Document -->
<div class="bbn-overlay">
  <bbn-splitter :resizable="true"
                :collapsible="true"
                ref="splitter"
                orientation="horizontal">
    <bbn-pane :scrollable="true"
              size="50%"
              ref="leftPane">
      <div class="bbn-vlpadded bbn-hlpadded bbn-w-100">
        <div v-for="(cfg, i) in source"
             class="bbn-w-100 bbn-vspadded">
          <appui-note-cms-block :source="cfg"
                                :ref="'block' + i"
                                :selectable="true"
                                :overable="true"
                                :selected="currentEdited === i"
                                @click="changeEdited(i)"/>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane>
      <div class="bbn-overlay bbn-flex-height">
        <div v-if="currentEdited > -1"
             class="bbn-header bbn-padded bbn-vmiddle bbn-m bbn-b bbn-flex-width">
          <div class="bbn-middle bbn-flex-fill">
            <bbn-dropdown :source="types"
                          v-model="currentType"/>
          </div>
          <div class="bbn-middle bbn-nowrap bbn-flex-fill">
            <?= _("Position of the block") ?>
            <span class="bbn-left-space"
                  v-text="currentEdited + 1"/>
            <bbn-button class="bbn-left-space"
                        :notext="true"
                        @click="move('top')"
                        text="<?= _("Move top") ?>"
                        :disabled="(this.source.length <= 1) || (currentEdited <= 1)"
                        icon="nf nf-mdi-arrow_collapse_up"/>
            <bbn-button :notext="true"
                        @click="move('up')"
                        text="<?= _("Move up") ?>"
                        :disabled="(this.source.length <= 1) || !currentEdited"
                        icon="nf nf-mdi-arrow_up"
                        class="bbn-left-xsspace"/>
            <bbn-button :notext="true"
                        @click="move('down')"
                        text="<?= _("Move down") ?>"
                        :disabled="(this.source.length <= 1) || (currentEdited === this.source.length - 1)"
                        icon="nf nf-mdi-arrow_down"
                        class="bbn-left-xsspace"/>
            <bbn-button :notext="true"
                        @click="move('bottom')"
                        text="<?= _("Move bottom") ?>"
                        :disabled="(this.source.length <= 1) || (currentEdited >= this.source.length - 2)"
                        icon="nf nf-mdi-arrow_collapse_down"
                        class="bbn-left-xsspace"/>
            <bbn-button class="bbn-left-space"
                        :notext="true"
                        @click="deleteCurrentSelected"
                        text="<?= _("Delete this block") ?>"
                        icon="nf nf-fa-trash"/>
          </div>
        </div>
        <div class="bbn-flex-fill">
          <div v-if="currentEdited === -1">
            <slot/>
          </div>
          <bbn-scroll v-else>
            <div class="bbn-w-100 bbn-middle">
              <div class="bbn-w-100 bbn-vlpadded bbn-hxlpadded">
                <appui-note-cms-block class="bbn-contain"
                                      :source="source[currentEdited]"
                                      mode="edit"/>
              </div>
            </div>
          </bbn-scroll>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>
