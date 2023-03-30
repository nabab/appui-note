<!-- HTML Document -->
<div :class="[componentClass, 'bbn-overlay']">
  <div class="bbn-100"
       ref="container">
    <div class="bbn-overlay bbn-flex-height">
      <div class="bbn-flex" style="justify-content: center">
        <div class="bbn-flex bbn-spadding bbn-alt-background bbn-radius-bottom" style="justify-content: center; align-items: center; gap: 10px;">
          <!--<bbn-button icon="nf nf-mdi-undo"
                        :disabled="(history.length <= 1) || (historyIndex === history.length -1)"
                        @click="undo"
                        :notext="true"
                        title="<?= _("Undo") ?>"/>
            <bbn-button icon="nf nf-mdi-redo"
                        :disabled="(history.length <= 1) || (historyIndex <= 1)"
                        @click="redo"
                        :notext="true"
                        title="<?= _("Redo") ?>"/>-->
          <bbn-dropdown :source="displayModes"
                        v-model="displayMode"
                        class="bbn-narrow"/> 
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
          <bbn-button icon="nf nf-md-code_json"
                      v-if="isDev"
                      title="<?= _("See JSON") ?>"
                      @click="showJSON = !showJSON"
                      :notext="true"/>
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
                  :scrollable="false"/>
        <div class="bbn-block"
             :style="currentDisplayMode.cfg">
          <bbn-json-editor v-if="showJSON && isDev"
                           :expanded="1"
                           v-model="jsonValue"/>
          <bbn-scroll v-else
                      @scroll="scrollElementor">
            <appui-note-cms-elementor :source="source.items"
                                      @hook:mounted="ready = true"
                                      ref="elementor"
                                      :all-blocks="allBlocks"
                                      @changes="handleSelected"
                                      v-droppable="true"
                                      @drop.prevent="onDrop"
                                      :preview="preview"
                                      @dragoverdroppable="dragOver"
                                      :position="nextPosition"
                                      @dragstart="dragStart"
                                      @changeposition="updateIndexes"
                                      @unselect="unselectElements"/>
          </bbn-scroll>
        </div>
      </div>
    </div>
    <!--Wigets properties-->
    <div :class="['bbn-top-right bbn-h-100 bbn-background', {slider: true, opened: showSlider}]">
      <bbn-scroll axis="y">
        <div class="bbn-w-100"
             v-if="currentEdited"
             >
          <h2 v-text="currentEditedTitle"
              class="bbn-c" />
          <div class="bbn-w-100 bbn-flex-width">
            <div v-if="elementorContainerIndex > -1"
                 class="bbn-spadding appui-note-cms-editor-position">
              <bbn-button :notext="true"
                          @click="move('top')"
                          text="<?= _("Move top") ?>"
                          :disabled="(source.items.length <= 1) || (elementorIndex < 1)"
                          icon="nf nf-mdi-arrow_collapse_up"/>
              <bbn-button :notext="true"
                          @click="move('up')"
                          text="<?= _("Move up") ?>"
                          :disabled="(source.items.length <= 1) || !elementorIndex"
                          icon="nf nf-mdi-arrow_up"/>
              <bbn-button :notext="true"
                          @click="move('down')"
                          text="<?= _("Move down") ?>"
                          :disabled="(source.items.length <= 1) || (elementorIndex === source.items.length - 1)"
                          icon="nf nf-mdi-arrow_down"/>
              <bbn-button :notext="true"
                          @click="move('bottom')"
                          text="<?= _("Move bottom") ?>"
                          :disabled="(source.items.length <= 1) || (elementorIndex > source.items.length - 2)"
                          icon="nf nf-mdi-arrow_collapse_down"/>
              <bbn-button :notext="true"
                          @click="scrollToSelected"
                          text="<?= _("Scroll to selected element") ?>"
                          icon="nf nf-mdi-target"/>
              <template v-if="(elementorContainerIndex === -1) && (elementorIndex !== -1)"
                        class="bbn-padding appui-note-cms-editor-position">
                <bbn-button :notext="true"
                            @click="move('top')"
                            text="<?= _("Move top") ?>"
                            :disabled="(source.items.length <= 1) || (elementorIndex < 1)"
                            icon="nf nf-mdi-arrow_collapse_up"/>
                <bbn-button :notext="true"
                            @click="move('up')"
                            text="<?= _("Move up") ?>"
                            :disabled="(source.items.length <= 1) || (elementorIndex < 1)"
                            icon="nf nf-mdi-arrow_up"/>
                <bbn-button :notext="true"
                            @click="move('down')"
                            text="<?= _("Move down") ?>"
                            :disabled="(source.items.length <= 1) || (elementorIndex >= source.items.length - 1)"
                            icon="nf nf-mdi-arrow_down"/>
                <bbn-button :notext="true"
                            @click="move('bottom')"
                            text="<?= _("Move bottom") ?>"
                            :disabled="(source.items.length <= 1) || (elementorIndex >= source.items.length - 1)"
                            icon="nf nf-mdi-arrow_collapse_down"/>
              </template>
              <!-- Leo to do -->
              <template v-else-if="elementorContainerIndex !== -1"
                        class="bbn-padding appui-note-cms-editor-position">
                <bbn-button :notext="true"
                            @click="move('left')"
                            text="<?= _("Move left") ?>"
                            :disabled="(elementorContainerIndex < 1)"
                            icon="nf nf-mdi-arrow_left"/>
                <bbn-button :notext="true"
                            @click="move('right')"
                            text="<?= _("Move right") ?>"
                            :disabled="(elementorContainerIndex >= source.items[elementorIndex].items.length -1)"
                            icon="nf nf-mdi-arrow_right"/>
              </template>
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
      <div class="bbn-top-right bbn-p bbn-spadding"
           @click="showSlider = false">
        <i class="nf nf-fa-times"/>
      </div>
    </div>
    <!--Widgets menu-->
    <div :class="['bbn-top-right bbn-h-100 bbn-background', {slider: true, opened: showWidgets}]">
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
      <div class="bbn-top-right bbn-p bbn-spadding"
           @click="showWidgets = false">
        <i class="nf nf-fa-times"/>
      </div>
    </div>
  </div>
</div>
