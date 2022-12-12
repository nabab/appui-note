<!-- HTML Document -->

<div class="bbn-bg-white bbn-padding bbn-flex bbn-radius">
  <div class="bbn-w-100 bbn-padded">
    <div class="bbn-grid-fields">
      <div class="bbn-grid-full bbn-middle bbn-bottom-padding bbn-xl">
        <?= _("Page's properties") ?>
      </div>
      <label><?= _("Title") ?></label>
      <bbn-input v-model="source.title"
                 :required="true"/>

      <label><?= _("Description") ?></label>
      <bbn-textarea v-model="source.excerpt"
                    style="height: 10em"
                    :required="true"/>

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

      <label><?= _("Public URL") ?></label>
      <appui-note-field-url :source="source"
                            v-model="source.url"
                            :readonly="true"/>

      <label><?= _("Start of publication") ?></label>
      <bbn-datetimepicker v-model="source.start"/>

      <label><?= _("End of publication") ?></label>
      <bbn-datetimepicker v-model="source.end"
                          :nullable="true"/>

      <label><?= _("Tags") ?></label>
      <bbn-values v-model="source.tags"/>

      <label><?=_('Cache')?></label>
      <div>
        <bbn-button :text="_('Clear')"
                    icon="nf nf-mdi-cached"
                    @click="emitClearCache"/>
      </div>
    </div>
    <div class="bbn-flex bbn-top-lmargin" style="justify-content: center; gap: 10px">
      <bbn-button :text="_('Cancel')"
                  @click="close"/>
      <bbn-button class="bbn-bg-webblue"
                  :text="_('Save')"
                  @click="save"/>
    </div>
  </div>
</div>
