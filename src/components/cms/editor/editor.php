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
                                    @changes="handleChanges"
                                    v-droppable="true"
                                    @drop.prevent="onDrop"
                                    :preview="preview"
                                    @dragoverdroppable="dragOver"
                                    :position="nextPosition"
                                    @dragstart="dragStart">
          </appui-note-cms-elementor>
        </bbn-scroll>
      </div>
    </div>
    <!--Wigets properties-->
    <div :class="{slider: true, opened: showSlider}">
      <bbn-scroll axis="y">
        <div class="bbn-w-100 bbn-middle bbn-flex"
             v-if="currentEdited !== null"
             style="flex-direction: column;">
          <div class="bbn-w-100 bbn-padded">
            <appui-note-cms-block class="bbn-contain"
                                  :source="currentEdited"
                                  mode="edit"/>
          </div>
          <div class="bbn-flex" style="gap: 10px; justify-content: center: align-items: center;">
            <bbn-button @click="deleteCurrentSelected"
                        text="<?= _("Delete this block") ?>"
                        icon="nf nf-fa-trash"/>
            <bbn-button :notext="true"
                        @click="move('top')"
                        text="<?= _("Move top") ?>"
                        :disabled="(source.items.length <= 1) || (currentEdited <= 1)"
                        icon="nf nf-mdi-arrow_collapse_up"/>
            <bbn-button :notext="true"
                        @click="move('up')"
                        text="<?= _("Move up") ?>"
                        :disabled="(source.items.length <= 1) || !currentEdited"
                        icon="nf nf-mdi-arrow_up"/>
            <bbn-button :notext="true"
                        @click="move('down')"
                        text="<?= _("Move down") ?>"
                        :disabled="(source.items.length <= 1) || (currentEdited === source.length - 1)"
                        icon="nf nf-mdi-arrow_down"/>
            <bbn-button :notext="true"
                        @click="move('bottom')"
                        text="<?= _("Move bottom") ?>"
                        :disabled="(source.items.length <= 1) || (currentEdited >= source.length - 2)"
                        icon="nf nf-mdi-arrow_collapse_down"/>
          </div>
        </div>
        <div v-else-if="!currentEdited && currentContainer">
          
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
        <div class="bbn-w-100 bbn-middle bbn-lpadding bbn-grid grid bbn-unselectable">
          <appui-note-cms-dropper v-for="(v, i) in blocks"
                                  :key="v.code"
                                  :description="v.description"
                                  :class="['block-' + v.code]"
                                  :type="v.code"
                                  :title="v.text"
                                  :icon="v.icon"
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
