<!-- HTML Document -->
<div :class="[componentClass, 'bbn-overlay', 'bbn-flex-height']">
  <div class="bbn-flex" style="justify-content: center">
    <div class="bbn-w-10 bbn-flex bbn-spadding bbn-bg-grey bbn-xxxl" style="justify-content: center; align-items: center; gap: 10px;">
      <bbn-button class="nf nf-fa-save"
                  title="<?= _("Save the note") ?>"
                  :disabled="!isChanged"
                  @click="() => {$refs.form.submit()}"/>
      <!--<bbn-button class="bbn-left-sspace nf nf-mdi-cursor_default_outline bbn-lg"
                title="<?= _("Select the note") ?>"
                :disabled="!ready || ($refs.editor.currentEdited === -1)"
                :notext="true"
                @click="() => {$refs.editor.currentEdited = -1}"/>-->
      <!--<bbn-context class="bbn-left-sspace"
                 :source="contextSource">
      <bbn-button class="nf nf-mdi-plus_outline bbn-lg"
                  :notext="true"
                  secondary="nf nf-fa-caret_down"
                  text="<?= _("Add a new block") ?>"/>
    </bbn-context>-->
      <bbn-button class="nf nf-mdi-settings"
                  title="<?= _("Page's properties") ?>"
                  @click="openSettings"/>
    </div>
  </div>
  <div class="bbn-flex-fill">
    <bbn-form ref="form"
              class="bbn-hidden"
              @success="onSave"
              @submit="submit"
              :source="source"
              :action="action"
              :buttons="[]"/>
    <appui-note-cms-elementor :source="source.items"
                              @hook:mounted="ready = true"
                              ref="editor">
      <bbn-scroll v-if="$slots.default">
        <slot/>
      </bbn-scroll>
    </appui-note-cms-elementor>
  </div>
  <div class="bbn-modal bbn-overlay"
       v-if="showFloater">
  </div>
  <bbn-floater :modal="true"
               v-if="showFloater">
    <appui-note-cms-settings :source="source"
                             :typeNote="typeNote"
                             @clear="clearCache"
                             @close="closeSettings"
                             @save="saveSettings"/>
  </bbn-floater>
</div>
