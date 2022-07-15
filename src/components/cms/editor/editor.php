<!-- HTML Document -->
<div :class="[componentClass, 'bbn-overlay', 'bbn-flex-height']">
  <bbn-toolbar class="bbn-header">
    <span class="bbn-lg bbn-b bbn-left-space"
         v-text="source.title"/>
    <div/>
    <bbn-button class="bbn-left-sspace nf nf-fa-save bbn-lg"
                title="<?= _("Save the note") ?>"
                :notext="true"
                :disabled="!isChanged"
                @click="() => {$refs.form.submit()}"/>
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
    <bbn-form ref="form"
              class="bbn-hidden"
              @success="onSave"
              :source="source"
              :action="action"
              :buttons="[]"/>
    <appui-note-cms-elementor :source="source.items"
                              @hook:mounted="ready = true"
                              ref="editor">
      <bbn-scroll v-if="$slots.default">
        <slot/>
      </bbn-scroll>
      <bbn-scroll v-else>
        <div class="bbn-w-100 bbn-padded">
          <div class="bbn-grid-fields">
            <div class="bbn-grid-full bbn-bottom-padding bbn-xl">
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
            <bbn-datetimepicker v-model="source.end"/>

            <label><?= _("Tags") ?></label>
            <bbn-values v-model="source.tags"/>

            <label><?=_('Cache')?></label>
            <div>
              <bbn-button :text="_('Clear')"
                          icon="nf nf-mdi-cached"
                          @click="clearCache"/>
            </div>
          </div>
        </div>
      </bbn-scroll>
    </appui-note-cms-elementor>
  </div>
</div>
