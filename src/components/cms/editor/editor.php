<!-- HTML Document -->
<div :class="[componentClass, 'bbn-overlay']">
  <div class="bbn-overlay bbn-flex-width"
       bbn-if="data">
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
          <bbn-button icon="nf nf-fa-gear"
                      title="<?= _("Page's properties") ?>"
                      @click="togglePageSettings"
                      :notext="true"/>
          <bbn-button icon="nf nf-md-widgets"
                      title="<?= _("widgets") ?>"
                      :notext="true"
                      @click="toggleWidgets"/>
          <bbn-button icon="nf nf-md-code_json"
                      bbn-if="isDev"
                      title="<?= _("See JSON") ?>"
                      @click="showJSON = !showJSON"
                      :notext="true"/>
          <bbn-button icon="nf nf-fa-eye"
                      :class="{'bbn-primary': preview}"
                      title="<?= _("Preview") ?>"
                      :notext="true"
                      @click="preview = !preview"/>
          <bbn-button icon="nf nf-cod-preview"
                      :class="{'bbn-primary': fullPreview}"
                      title="<?= _("Full preview") ?>"
                      :notext="true"
                      @click="() => toggleFullPreview()"/>
          <bbn-button icon="nf nf-fa-external_link"
                      title="<?= _("Full preview in new window") ?>"
                      :notext="true"
                      @click="externalFullPreview"/>
        </div>
      </div>
      <div class="bbn-flex-fill">
        <iframe bbn-if="!!fullPreview"
                :src="fullPreview"
                class="bbn-100"/>
        <bbn-scroll bbn-else
                    class="bbn-overlay"
                    @scroll="scrollElementor">
          <bbn-json-editor bbn-if="showJSON && isDev"
                           :expanded="1"
                           bbn-model="source.items"/>
          <appui-note-cms-elementor bbn-else
                                    :source="source.items"
                                    @hook:mounted="ready = true"
                                    ref="editor"
                                    :all-blocks="allBlocks"
                                    @changes="handleSelected"
                                    @drop.prevent="onDrop"
                                    :preview="preview"
                                    :position="nextPosition"
                                    @dragstart="dragStart"
                                    @unselect="unselectElements"
                                    :dragging="isDragging"
                                    :item-selected="currentEditingKey"/>
        </bbn-scroll>
      </div>
    </div>

    <!-- Slider -->
    <div bbn-if="!fullPreview"
         :class="['slider', 'bbn-flex-height', {opened: showSlider, maximized: !!sliderMaximized}]"
         bbn-resizable.left="true"
         ref="slider">
      <div class="bbn-spadding bbn-vmiddle"
           style="justify-content: space-between">
        <i bbn-if="sliderMaximized"
           class="nf nf-fa-window_restore bbn-p"
           @click="sliderMaximized = false"/>
        <i bbn-else
           class="nf nf-fa-window_maximize bbn-p"
           @click="sliderMaximized = true"/>
        <i class="nf nf-fa-times bbn-p"
           @click="closeSlider"/>
      </div>
      <h2 class="bbn-c"
          style="margin-top: 0">
        <span bbn-if="showWidgetSettings"
              bbn-text="currentEditingTitle"/>
        <span bbn-else-if="showWidgets"
              bbn-text="_('Widgets')"/>
        <span bbn-else-if="showPageSettings"
              bbn-text="_('Page Settings')"/>
      </h2>
      <div class="bbn-flex-fill">
        <div bbn-if="showWidgetSettings && currentEditing"
              class="bbn-flex-height">
          <div class="bbn-flex-fill bbn-flex-width">
            <div class="bbn-spadding appui-note-cms-editor-position">
              <bbn-button :notext="true"
                          @click="scrollToSelected"
                          label="<?= _("Scroll to selected element") ?>"
                          icon="nf nf-md-target"/>
              <template bbn-if="!!currentEditingParent && (currentEditingParentItems?.length > 1)"
                        class="bbn-padding appui-note-cms-editor-position">
                <bbn-button :notext="true"
                            @click="move('start')"
                            label="<?= _("Move to start") ?>"
                            :disabled="currentEditingIndex < 1"
                            :icon="(currentEditingParent.source?.type !== 'container') || (currentEditingParent.source.orientation === 'vertical') ? 'nf nf-md-arrow_collapse_up' : 'nf nf-md-arrow_collapse_left'"/>
                <bbn-button :notext="true"
                            @click="move('before')"
                            :label="(currentEditingParent.source?.type !== 'container') || (currentEditingParent.source.orientation === 'vertical') ? _('Move up') : _('Move left')"
                            :disabled="!currentEditingIndex"
                            :icon="(currentEditingParent.source?.type !== 'container') || (currentEditingParent.source.orientation === 'vertical') ? 'nf nf-md-arrow_up' : 'nf nf-md-arrow_left'"/>
                <bbn-button :notext="true"
                            @click="move('after')"
                            :label="(currentEditingParent.source?.type !== 'container') || (currentEditingParent.source.orientation === 'vertical') ? _('Move down') : _('Move right')"
                            :disabled="currentEditingIndex === (currentEditingParentItems.length - 1)"
                            :icon="(currentEditingParent.source?.type !== 'container') || (currentEditingParent.source.orientation === 'vertical') ? 'nf nf-md-arrow_down' : 'nf nf-md-arrow_right'"/>
                <bbn-button :notext="true"
                            @click="move('end')"
                            label="<?= _("Move to end") ?>"
                            :disabled="currentEditingIndex === (currentEditingParentItems.length - 1)"
                            :icon="(currentEditingParent.source?.type !== 'container') || (currentEditingParent.source.orientation === 'vertical') ? 'nf nf-md-arrow_collapse_down' : 'nf nf-md-arrow_collapse_right'"/>
              </template>
            </div>
            <div class="bbn-flex-fill bbn-right-spadding"
                  style="overflow: hidden">
              <div class="bbn-100">
                <bbn-scroll axis="y">
                  <appui-note-cms-container bbn-if="currentEditing.type === 'container'"
                                            @configinit="setOriginalConfig"
                                            class="bbn-contain bbn-w-100"
                                            :source="currentEditing"
                                            ref="blockEditor"
                                            mode="edit"
                                            :key="currentEditing._elementor.key"/>
                  <appui-note-cms-block bbn-else
                                        @configinit="setOriginalConfig"
                                        :class="['bbn-contain', 'bbn-w-100', {
                                          'bbn-overlay': currentEditing.type === 'html'
                                        }]"
                                        :source="currentEditing"
                                        :cfg="currentBlockConfig"
                                        ref="blockEditor"
                                        mode="edit"
                                        :key="currentEditing._elementor.key"/>
                </bbn-scroll>
              </div>
            </div>
          </div>
          <div class="bbn-w-100 bbn-c bbn-padding bbn-middle bbn-grid-xsgap">
            <bbn-button @click="saveConfig"
                        label="<?= _("Create new block type") ?>"
                        title="<?= _("Create new block type") ?>"
                        icon="nf nf-fa-save"
                        :disabled="!isConfigChanged"
                        class="bbn-ellipsis"/>
            <bbn-button @click="deleteCurrentSelected"
                        label="<?= _("Delete block") ?>"
                        title="<?= _("Delete this block") ?>"
                        icon="nf nf-fa-trash"
                        class="bbn-ellipsis"/>
          </div>
        </div>
        <bbn-scroll bbn-else-if="showWidgets"
                    axis="y">
          <div class="bbn-lpadding bbn-flex-wrap grid-dropper bbn-unselectable">
            <appui-note-cms-dropper bbn-for="(v, i) in allBlocks"
                                    :key="v.id"
                                    :description="v.description"
                                    :class="'block-' + v.code"
                                    :type="v.code"
                                    :special="v.special"
                                    :label="v.text"
                                    :icon="v.icon"
                                    :default-config="v.cfg"
                                    @dragend="isDragging = false"
                                    @dragstart="isDragging = true"/>
          </div>
        </bbn-scroll>
        <div bbn-else-if="showPageSettings"
             class="bbn-overlay">
          <bbn-scroll axis="y">
            <slot bbn-if="$slots.default?.length"/>
            <appui-note-cms-settings bbn-else
                                    :source="source"
                                    :type-note="typeNote"
                                    @clear="clearCache"/>
          </bbn-scroll>
        </div>
      </div>
    </div>

  </div>
</div>
