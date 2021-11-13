<!-- HTML Document -->
<appui-note-cms-editor :source="source">
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
      <appui-note-cms-url :source="source"
                          class="bbn-wider"
                          :readonly="true"/>

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
</appui-note-cms-editor>
