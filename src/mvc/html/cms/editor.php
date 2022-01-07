<!-- HTML Document -->
<appui-note-cms-editor :source="source.data">
  <div class="bbn-w-100">
    <div class="bbn-grid-fields bbn-padded">
      <div class="bbn-grid-full bbn-vpadded bbn-xl">
        <?= _("Page's properties") ?>
      </div>
      <label><?= _("Title") ?></label>
      <bbn-input class="bbn-wider"
                 v-model="source.data.title"
                 :required="true"/>

      <label><?= _("Type") ?></label>
      <bbn-dropdown class="bbn-wider"
                    v-model="source.data.id_type"
                    source-value="id"
                    :source="source.types"
	                  :required="true"/>

      <label><?= _("Public URL") ?></label>
      <appui-note-cms-url :source="source.data"
                          class="bbn-wider"
                          :readonly="true"/>

      <label><?= _("Start of publication") ?></label>
      <bbn-datetimepicker class="bbn-wider"
                          v-model="source.data.start"/>

      <label><?= _("End of publication") ?></label>
      <bbn-datetimepicker class="bbn-wider"
                          v-model="source.data.end"/>

      <label><?= _("Tags") ?></label>
      <bbn-values class="bbn-wider"
                  v-model="source.data.tags"/>
    </div>
  </div>
</appui-note-cms-editor>
