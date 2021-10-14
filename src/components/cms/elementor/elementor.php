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
                                :selected="currentEdited === i"
                                @click="changeEdited(i)"/>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane>
      <div class="bbn-overlay bbn-flex-height">
        <div v-if="currentEdited > -1"
             class="bbn-header bbn-padded bbn-vmiddle bbn-m bbn-b">
          <div class="bbn-block-left bbn-middle">
            <bbn-dropdown :source="types"
                          v-model="currentType"/>
          </div>
          <div class="bbn-block-right bbn-middle">
            <?= _("Position of the block") ?>
            <span class="bbn-left-space"
                  v-text="currentEdited + 1"/>
          </div>
        </div>
        <div class="bbn-flex-fill">
          <div v-if="currentEdited === -1">
            <slot/>
          </div>
          <div class="bbn-overlay"
               v-else>
            <div class="bbn-w-100 bbn-middle">
              <div class="bbn-block bbn-vlpadded bbn-hxlpadded">
                <appui-note-cms-block class="bbn-contain"
                                      :source="cfgs[currentEdited]"
                                      mode="edit"/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>
