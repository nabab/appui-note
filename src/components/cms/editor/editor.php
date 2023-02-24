<!-- HTML Document -->
<div :class="[componentClass, 'bbn-overlay']">
  <div class="bbn-overlay bbn-flex-width">
    <!--Elementor-->
    <div class="bbn-flex-fill bbn-flex-height">
      <div class="bbn-flex" style="justify-content: center">
        <div class="bbn-flex bbn-spadding bbn-alt-background bbn-radius-bottom bbn-xl" style="justify-content: center; align-items: center; gap: 10px;">
          <bbn-button icon="nf nf-fa-save"
                      title="<?= _("Save the note") ?>"
                      :disabled="!isChanged"
                      @click="() => {$refs.form.submit()}"
                      :notext="true"/>
          <bbn-button icon="nf nf-mdi-settings"
                      title="<?= _("Page's properties") ?>"
                      @click="showFloater = true"
                      :notext="true"/>
          <bbn-button icon="nf nf-mdi-widgets"
                      title="<?= _("widgets") ?>"
                      :notext="true"
                      @click="() => {
                              showWidgets = !showWidgets;
                              showSlider = false;
                              }"/>
          <bbn-button icon="nf nf-fa-eye"
                      :class="{'bbn-primary': preview}"
                      title="<?= _("Preview") ?>"
                      :notext="true"
                      @click="preview = !preview"/>
        </div>
      </div>
      <div class="bbn-flex-fill">
        <bbn-form ref="form"
                  class="bbn-hidden"
                  @success="onSave"
                  @submit="submit"
                  :source="source"
                  :action="action"
                  :buttons="[]"
                  :scrollable="true"/>
        <bbn-scroll class="bbn-overlay"
                    @scroll="scrollElementor">
          <appui-note-cms-elementor :source="source.items"
                                    @hook:mounted="ready = true"
                                    ref="editor"
                                    :all-blocks="allBlocks"
                                    @changes="handleSelected"
                                    v-droppable="true"
                                    @drop.prevent="onDrop"
                                    :preview="preview"
                                    @dragoverdroppable="dragOver"
                                    :position="nextPosition"
                                    @dragstart="dragStart"
                                    @unselect="unselectElements">
          </appui-note-cms-elementor>
        </bbn-scroll>
      </div>
    </div>
    <!--Wigets properties-->
    <div :class="{slider: true, opened: showSlider}">
      <bbn-scroll axis="y">
        <div class="bbn-w-100"
             v-if="currentEdited"
             >
          <h2 v-text="currentEditedTitle"
              class="bbn-c" />
          <div class="bbn-w-100 bbn-flex-width">
            <div v-if="!currentEditedIndexInContainer"
                 class="bbn-padding appui-note-cms-editor-position">
              <bbn-button :notext="true"
                          @click="move('top')"
                          text="<?= _("Move top") ?>"
                          :disabled="(source.items.length <= 1) || (currentEditedIndex < 1)"
                          icon="nf nf-mdi-arrow_collapse_up"/>
              <bbn-button :notext="true"
                          @click="move('up')"
                          text="<?= _("Move up") ?>"
                          :disabled="(source.items.length <= 1) || !currentEditedIndex"
                          icon="nf nf-mdi-arrow_up"/>
              <bbn-button :notext="true"
                          @click="move('down')"
                          text="<?= _("Move down") ?>"
                          :disabled="(source.items.length <= 1) || (currentEditedIndex === source.items.length - 1)"
                          icon="nf nf-mdi-arrow_down"/>
              <bbn-button :notext="true"
                          @click="move('bottom')"
                          text="<?= _("Move bottom") ?>"
                          :disabled="(source.items.length <= 1) || (currentEditedIndex > source.items.length - 2)"
                          icon="nf nf-mdi-arrow_collapse_down"/>
            </div>
            <div class="bbn-flex-fill">
              <appui-note-cms-block	@configinit="setOriginalConfig"
                                    v-if="isReady"
                                    class="bbn-contain"
                                    :source="currentEdited"
                                    :cfg="currentBlockConfig"
                                    ref="blockEditor"
                                    mode="edit"/>
            </div>

          </div>
          <div class="bbn-w-100 bbn-c bbn-padding">
            <bbn-button @click="saveConfig"
                        text="<?= _("Create new block type") ?>"
                        icon="nf nf-fa-save"
                        :disabled="!isConfigChanged"/>
            <bbn-button @click="deleteCurrentSelected"
                        text="<?= _("Delete this block") ?>"
                        icon="nf nf-fa-trash"/>
          </div>
        </div>
        <div v-else-if="!currentEdited && currentContainer">
          <appui-note-cms-container-config :source="currentContainer"/>
        </div>
      </bbn-scroll>
      <div class="bbn-top-right bbn-p bbn-lg"
           @click="showSlider = false">
        <i class="nf nf-fa-times"></i>
      </div>
    </div>
    <!--Widgets menu-->
    <div :class="{slider: true, opened: showWidgets}">
      <bbn-scroll axis="y">
        <div class="bbn-w-100 bbn-middle bbn-lpadding bbn-grid grid-dropper bbn-unselectable">
          <appui-note-cms-dropper v-for="(v, i) in allBlocks"
                                  :key="v.id"
                                  :description="v.description"
                                  :class="['block-' + v.code, {'bbn-pink': v.special}]"
                                  :type="v.code"
                                  :special="v.special"
                                  :title="v.text"
                                  :icon="v.icon"
                                  :default-config="v.cfg"
                                  />
        </div>
      </bbn-scroll>
      <div class="bbn-top-right bbn-p bbn-lg"
           @click="showWidgets = false">
        <i class="nf nf-fa-times"></i>
      </div>
    </div>
  </div>
  <!--Settings-->
  <div class="bbn-modal bbn-overlay"
       v-if="showFloater">
  </div>
  <bbn-floater :modal="true"
               v-if="showFloater">
    <appui-note-cms-settings :source="source"
                             :typeNote="typeNote"
                             @clear="clearCache"
                             @close="showFloater = false"
                             @save="saveSettings"/>
  </bbn-floater>
</div>
