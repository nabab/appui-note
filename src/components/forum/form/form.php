<bbn-form class="appui-note-forum-form"
          :action="formAction"
          :source="source"
					:data="formData"
          @success="formSuccess">
  <appui-note-toolbar-version v-if="data.id && source.hasVersions"
                              :source="source"
                              :data="data"
                              @version="changeVersion"/>
  <div class="bbn-grid-fields bbn-padded">
    <template v-if="source.title !== undefined">
      <label><?= _("Title") ?></label>
      <bbn-input v-model="source.title"/>
    </template>

    <template v-if="(source.category !== undefined) && categories">
      <label><?= _("Category") ?></label>
      <bbn-dropdown required="required"
                    v-model="source.category"
                    :source="categories"/>
    </template>

    <!--<div style="text-align: right">
      <label><?= _("Text") ?></label>
      <br>
      <bbn-dropdown :source="editorTypes"
                    ref="editorType"
                    @change="switchEditorType"
      ></bbn-dropdown>
    </div>-->
    <label><?= _("Text") ?></label>
    <div>
      <div class="bbn-w-100">
        <component :is="editorType"
                   ref="editor"
                   v-model="source.text"
                   style="min-height: 450px; width: 100%;"
                   required="required"
                   class="bbn-w-100"
                   height="450px"/>
      </div>
    </div>

    <template v-if="fileSave && fileRemove">
      <label><?= _("Files") ?></label>
      <div class="bbn-task-files-container">
        <bbn-upload :save-url="fileSave + ref"
                    :remove-url="fileRemove + ref"
                    v-model="source.files"
                    :paste="true"
                    :show-filesize="false"/>
      </div>
    </template>

    <!--
    <label><?= _("Links") ?></label>
    <div>
      <div class="bbn-w-100">
        <bbn-input ref="link"
                   @keydown.enter.prevent.stop="linkEnter"
                   placeholder="<?= _("Type or paste your URL and press Enter to valid") ?>"
                   class="bbn-w-100"/>
      </div>
      <div class="appui-note-forum-links-container bbn-widget bbn-w-100"
           ref="linksContainer"
           v-if="source.links && source.links.length">
        <div v-for="(l, idx) in source.links"
             :class="['bbn-spadded', {
               'link-progress': l.inProgress && !l.error,
               'link-success': !l.inProgress && !l.error,
               'link-error': l.error,
               'bbn-bordered-top': idx > 0
             }]">
          <div class="bbn-flex-width">
            <div v-if="imageDom"
                 class="appui-note-forum-link-image">
              <img v-if="l.image"
                   :src="imageDom + ref + '/' + l.image">
              <i v-else class="nf nf-fa-link"> </i>
            </div>
            <div class="appui-note-forum-link-title bbn-flex-fill">
              <strong>
                <a :href="l.content.url"
                   v-text="l.title || l.content.url"/>
              </strong>
              <br>
              <span v-if="l.content && l.content.description"
                    v-text="l.content.description"/>
            </div>
            <div class="appui-note-forum-link-actions bbn-vmiddle">
              <bbn-button class="bbn-button-icon-only"
                          style="display: inline-block;"
                          @click="linkRemove(idx)"
                          icon="nf nf-fa-times"
                          title="<?= _('Remove') ?>"/>
            </div>
          </div>
        </div>
      </div>
    </div>-->

    <label><?= _("Important") ?></label>
    <div>
      <bbn-checkbox v-model="source.important"
                    :value="1"
                    :novalue="0"/>
    </div>
    <template v-if="canLock">
      <label><?= _("Locked") ?></label>
      <div>
        <bbn-checkbox v-model="source.locked"
                      :value="1"
                      :novalue="0"/>
      </div>
    </template>
  </div>
</bbn-form>
