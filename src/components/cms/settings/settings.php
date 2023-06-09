<!-- HTML Document -->

<div class="appui-note-cms-settings bbn-grid-fields bbn-padded">
  <label class="bbn-label"><?= _("Title") ?></label>
  <bbn-input v-model="source.title"
              :required="true"/>

  <label  class="bbn-label"><?= _("Description") ?></label>
  <bbn-textarea v-model="source.excerpt"
                style="height: 10em"
                :required="true"
                :resizable="false"/>

  <label v-if="typeNote && typeNote.front_img"
          style="margin-top:10px">
    <?=_('Front Image')?>
  </label>
  <appui-note-media-field v-if="typeNote && typeNote.front_img"
                          v-model="source.id_media"
                          :source="source.medias || []"/>

  <label v-if="typeNote && typeNote.option"
          v-text="typeNote.option_title || _('Category')"/>
  <div v-if="typeNote && typeNote.option">
    <bbn-dropdown v-if="typeNote.options"
                  :source="typeNote.options"
                  v-model="source.id_option"/>
    <appui-option-input-picker v-else
                                v-model="source.id_option"/>
  </div>

  <label  class="bbn-label"><?= _("Public URL") ?></label>
  <appui-note-field-url :source="source"
                        v-model="source.url"
                        :readonly="true"/>

  <label  class="bbn-label"><?= _("Start of publication") ?></label>
  <bbn-datetimepicker v-model="source.start"/>

  <label  class="bbn-label"><?= _("End of publication") ?></label>
  <bbn-datetimepicker v-model="source.end"
                      :nullable="true"/>

  <label  class="bbn-label"><?= _("Tags") ?></label>
  <bbn-values v-model="source.tags"/>

  <label  class="bbn-label"><?=_('Cache')?></label>
  <div>
    <bbn-button :text="_('Clear')"
                icon="nf nf-mdi-cached"
                @click="emitClearCache"/>
  </div>
</div>
