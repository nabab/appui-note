<!-- HTML Document -->
<div class="bbn-overlay">
  <bbn-splitter :resizable="true"
                :collapsible="true"
                ref="splitter"
                orientation="horizontal">
    <bbn-pane :scrollable="true"
              size="50%"
              ref="leftPane">
      <div class="bbn-vlpadded bbn-hlpadded">
        <div v-for="(cfg, i) in cfgs"
             class="bbn-w-100 bbn-vspadded">
          <appui-note-cms-block :source="cfg"
                                :ref="'block' + i"
                                :selectable="true"
                                :overable="true"
                                @click="currentEdited = i"/>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane>
      <div class="bbn-overlay bbn-flex-height">
        <bbn-toolbar class="bbn-flex-width bbn-hpadded"
                     ref="toolbar"
                     :source="toolbarSource">
          <bbn-context tag="div"
                       class="bbn-hsmargin"
                       :source="contextSource">
            <bbn-button icon="nf nf-mdi-plus_outline"
                        :notext="true"
                        secondary="nf nf-fa-caret_down"
                        text="<?= _("Ajouter un bloc") ?>"/>
          </bbn-context>
        </bbn-toolbar>
        <div v-if="currentEdited > -1"
             class="bbn-header bbn-padded bbn-vmiddle bbn-m bbn-b">
          <div class="bbn-block-left bbn-middle">
            <bbn-dropdown :source="types"
                          v-model="cfgs[this.currentEdited].type"/>
          </div>
          <div class="bbn-block-right bbn-middle">
            <?= _("Position of the block") ?>
            <span class="bbn-left-space"
                  v-text="currentEdited + 1"/>
          </div>
        </div>
        <div class="bbn-flex-fill">
          <div v-if="currentEdited === -1"
               class="bbn-overlay bbn-middle">
            <div>
              <?= _("Select an element on the left to edit it here") ?>
            </div>
          </div>
          <bbn-scroll v-else>
            <div class="bbn-w-100">
              <div class="bbn-block bbn-vlpadded bbn-hxlpadded">
                <appui-note-cms-block class="bbn-contain"
                                      :source="cfgs[currentEdited]"
                                      mode="edit"/>
              </div>
            </div>
          </bbn-scroll>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>
