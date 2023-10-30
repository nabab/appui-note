<!-- HTML Document -->
<div :class="[componentClass, 'bbn-overlay']">
  <div class="bbn-overlay bbn-flex-width"
       v-if="data">
    <!--Elementor-->
    <div class="bbn-flex-fill bbn-flex-height"
         style="background-color: var(--white); color: var(--black)">
      <!-- Dock -->
      <div class="bbn-middle">
        <div class="appui-note-cms-editor-dock bbn-middle bbn-spadding bbn-radius-bottom bbn-xl">
          <bbn-button icon="nf nf-fa-save"
                      title="<?= _("Save") ?>"
                      :disabled="!isChanged"
                      @click="save"
                      :notext="true"/>
          <bbn-button icon="nf nf-mdi-settings"
                      title="<?= _("Page's properties") ?>"
                      @click="togglePageSettings"
                      :notext="true"/>
          <bbn-button icon="nf nf-mdi-widgets"
                      title="<?= _("widgets") ?>"
                      :notext="true"
                      @click="toggleWidgets"/>
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
        <bbn-scroll class="bbn-overlay"
                    @scroll="scrollElementor">
          <bbn-json-editor v-if="showJSON && isDev"
                           :expanded="1"
                           v-model="source.items"/>
          <appui-note-cms-elementor v-else
                                    :source="source.items"
                                    @hook:mounted="ready = true"
                                    ref="editor"
                                    :all-blocks="allBlocks"
                                    @changes="handleSelected"
                                    @drop.prevent="onDrop"
                                    :preview="preview"
                                    @dragoverdroppable="dragOver"
                                    :position="nextPosition"
                                    @dragstart="dragStart"
                                    @unselect="unselectElements"
                                    :dragging="isDragging"
                                    :item-selected="currentEditingKey"/>
        </bbn-scroll>
      </div>
    </div>

    <!-- Slider -->
    <div :class="['slider', 'bbn-flex-height', {opened: showSlider, maximized: !!sliderMaximized}]"
         v-resizable.left="true"
         ref="slider">
      <div class="bbn-spadding bbn-vmiddle"
           style="justify-content: space-between">
        <i v-if="sliderMaximized"
           class="nf nf-fa-window_restore bbn-p"
           @click="sliderMaximized = false"/>
        <i v-else
           class="nf nf-fa-window_maximize bbn-p"
           @click="sliderMaximized = true"/>
        <i class="nf nf-fa-times bbn-p"
           @click="closeSlider"/>
      </div>
      <h2 class="bbn-c"
          style="margin-top: 0">
        <span v-if="showWidgetSettings"
              v-text="currentEditingTitle"/>
        <span v-else-if="showWidgets"
              v-text="_('Widgets')"/>
        <span v-else-if="showPageSettings"
              v-text="_('Page Settings')"/>
      </h2>
      <div class="bbn-flex-fill">
        <div v-if="showWidgetSettings && currentEditing"
              class="bbn-flex-height">
          <div class="bbn-flex-fill bbn-flex-width">
            <div class="bbn-spadding appui-note-cms-editor-position">
              <bbn-button :notext="true"
                          @click="scrollToSelected"
                          text="<?= _("Scroll to selected element") ?>"
                          icon="nf nf-mdi-target"/>
              <template v-if="currentEditingParentItems?.length > 1"
                        class="bbn-padding appui-note-cms-editor-position">
                <bbn-button :notext="true"
                            @click="move('start')"
                            text="<?= _("Move to start") ?>"
                            :disabled="currentEditingIndex < 1"
                            :icon="(currentEditingParent.source?.type !== 'container') || (currentEditingParent.source.orientation === 'vertical') ? 'nf nf-mdi-arrow_collapse_up' : 'nf nf-mdi-arrow_collapse_left'"/>
                <bbn-button :notext="true"
                            @click="move('before')"
                            :text="(currentEditingParent.source?.type !== 'container') || (currentEditingParent.source.orientation === 'vertical') ? _('Move up') : _('Move left')"
                            :disabled="!currentEditingIndex"
                            :icon="(currentEditingParent.source?.type !== 'container') || (currentEditingParent.source.orientation === 'vertical') ? 'nf nf-mdi-arrow_up' : 'nf nf-mdi-arrow_left'"/>
                <bbn-button :notext="true"
                            @click="move('after')"
                            :text="(currentEditingParent.source?.type !== 'container') || (currentEditingParent.source.orientation === 'vertical') ? _('Move down') : _('Move right')"
                            :disabled="currentEditingIndex === (currentEditingParentItems.length - 1)"
                            :icon="(currentEditingParent.source?.type !== 'container') || (currentEditingParent.source.orientation === 'vertical') ? 'nf nf-mdi-arrow_down' : 'nf nf-mdi-arrow_right'"/>
                <bbn-button :notext="true"
                            @click="move('end')"
                            text="<?= _("Move to end") ?>"
                            :disabled="currentEditingIndex === (currentEditingParentItems.length - 1)"
                            :icon="(currentEditingParent.source?.type !== 'container') || (currentEditingParent.source.orientation === 'vertical') ? 'nf nf-mdi-arrow_collapse_down' : 'nf nf-mdi-arrow_collapse_right'"/>
              </template>
            </div>
            <div class="bbn-flex-fill bbn-right-spadded"
                  style="overflow: hidden">
              <div class="bbn-100">
                <bbn-scroll axis="y">
                  <component	@configinit="setOriginalConfig"
                              :class="['bbn-contain', 'bbn-w-100', {'bbn-overlay': currentEditing.type === 'html'}]"
                              :source="currentEditing"
                              :cfg="currentBlockConfig"
                              ref="blockEditor"
                              mode="edit"
                              :is="currentEditing.type === 'container' ? 'appui-note-cms-container' : 'appui-note-cms-block'"
                              :key="currentEditing._elementor.key"/>
                </bbn-scroll>
              </div>
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
        <bbn-scroll v-else-if="showWidgets"
                    axis="y">
          <div class="bbn-lpadding bbn-flex-wrap grid-dropper bbn-unselectable">
            <appui-note-cms-dropper v-for="(v, i) in allBlocks"
                                    :key="v.id"
                                    :description="v.description"
                                    :class="'block-' + v.code"
                                    :type="v.code"
                                    :special="v.special"
                                    :title="v.text"
                                    :icon="v.icon"
                                    :default-config="v.cfg"
                                    @dragend="isDragging = false"
                                    @dragstart="isDragging = true"/>
          </div>
        </bbn-scroll>
        <div v-else-if="showPageSettings"
             class="bbn-overlay">
          <bbn-scroll axis="y">
            <slot v-if="$slots.default"/>
            <appui-note-cms-settings v-else
                                    :source="source"
                                    :type-note="typeNote"
                                    @clear="clearCache"/>
          </bbn-scroll>
        </div>
      </div>
    </div>

  </div>
</div>
