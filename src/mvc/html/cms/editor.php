<!-- HTML Document -->
<div class="bbn-overlay bbn-flex-height">
  <bbn-toolbar class="bbn-header">
    <span class="bbn-lg bbn-b bbn-left-space"
         v-text="source.title"/>
    <div/>
    <bbn-button class="bbn-left-sspace nf nf-fa-save bbn-lg"
                title="<?= _("Save the note") ?>"
                :notext="true"
                :disabled="!isChanged"
                @click="save"/>
    <bbn-button class="bbn-left-sspace nf nf-mdi-cursor_default_outline bbn-lg"
                title="<?= _("Select the note") ?>"
                :disabled="!ready || ($refs.editor.currentEdited === -1)"
                :notext="true"
                @click="() => {$refs.editor.currentEdited = -1}"/>
    <bbn-context class="bbn-left-sspace"
                 :source="contextSource">
      <bbn-button class="nf nf-mdi-plus_outline bbn-lg"
                  :notext="true"
                  secondary="nf nf-fa-caret_down"
                  text="<?= _("Add a new block") ?>"/>
    </bbn-context>
  </bbn-toolbar>
  <div class="bbn-flex-fill">
    <appui-note-cms-elementor :source="source.items"
                              @hook:mounted="ready = true"
                              ref="editor">
      <div class="bbn-w-100 bbn-middle">
        <div class="bbn-grid-fields bbn-padded">
          <div class="bbn-grid-full bbn-vpadded bbn-xl">
            <?= _("Page's properties") ?>
          </div>
          <label><?= _("Title") ?></label>
          <bbn-input class="bbn-wider"
                     v-model="source.title"
                     :required="true"/>

          <label><?= _("Public URL") ?></label>
          <bbn-input class="bbn-wider"
                     v-model="source.url"
                     :readonly="true"
                     :required="true"/>

          <label><?= _("Start of publication") ?></label>
          <bbn-datetimepicker class="bbn-wider"
                              v-model="source.start"/>

          <label><?= _("End of publication") ?></label>
          <bbn-datetimepicker class="bbn-wider"
                              v-model="source.end"/>

          <label><?= _("Tags") ?></label>
          <bbn-values class="bbn-wider"
                      v-model="source.tags"/>
        </div>
      </div>
    </appui-note-cms-elementor>
  </div>
</div>
