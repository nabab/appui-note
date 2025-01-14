<!-- HTML Document -->

<div class="appui-note-cms-settings bbn-grid-fields bbn-padding">
  <label class="bbn-label"><?= _("Title") ?></label>
  <bbn-input bbn-model="source.title"
              :required="true"/>

  <label  class="bbn-label"><?= _("Description") ?></label>
  <bbn-textarea bbn-model="source.excerpt"
                style="height: 10em"
                :required="true"
                :resizable="false"/>

  <label bbn-if="typeNote && typeNote.front_img"
          style="margin-top:10px">
    <?= _('Front Image') ?>
  </label>
  <appui-note-media-field bbn-if="typeNote && typeNote.front_img"
                          bbn-model="source.id_media"
                          :source="source.medias || []"/>

  <label bbn-if="typeNote && typeNote.option"
          bbn-text="typeNote.option_title || _('Category')"/>
  <div bbn-if="typeNote && typeNote.option">
    <bbn-dropdown bbn-if="typeNote.options"
                  :source="typeNote.options"
                  bbn-model="source.id_option"/>
    <appui-option-input-picker bbn-else
                                bbn-model="source.id_option"/>
  </div>

  <label  class="bbn-label"><?= _("Public URL") ?></label>
  <appui-note-field-url :source="source"
                        bbn-model="source.url"
                        :readonly="true"/>

  <label  class="bbn-label"><?= _("Start of publication") ?></label>
  <bbn-datetimepicker bbn-model="source.start"/>

  <label  class="bbn-label"><?= _("End of publication") ?></label>
  <bbn-datetimepicker bbn-model="source.end"
                      :nullable="true"/>

  <label  class="bbn-label"><?= _("Tags") ?></label>
  <bbn-values bbn-model="source.tags"/>

  <label  class="bbn-label"><?= _('Cache') ?></label>
  <div>
    <bbn-button :label="_('Clear')"
                icon="nf nf-mdi-cached"
                @click="emitClearCache"/>
  </div>
</div>
