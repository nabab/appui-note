<bbn-form class="appui-note-forum-form"
          :action="formAction"
          :source="source"
					:data="formData"
          @success="onFormSuccess">
  <appui-note-toolbar-version bbn-if="data.id && source.hasVersions"
                              :source="source"
                              :data="data"
                              @version="changeVersion"/>
  <div class="bbn-grid-fields bbn-padded">
    <template bbn-if="source.title !== undefined">
      <label><?= _("Title") ?></label>
      <bbn-input bbn-model="source.title"/>
    </template>

    <template bbn-if="(source.category !== undefined) && categories">
      <label><?= _("Category") ?></label>
      <bbn-dropdown required="required"
                    bbn-model="source.category"
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
                   bbn-model="source.text"
                   style="min-height: 450px; width: 100%;"
                   required="required"
                   class="bbn-w-100"
                   height="450px"/>
      </div>
    </div>

    <template bbn-if="fileSave && fileRemove">
      <label><?= _("Files") ?></label>
      <div class="bbn-task-files-container">
        <bbn-upload :save-url="fileSave + ref"
                    :remove-url="fileRemove + ref"
                    bbn-model="source.files"
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
           bbn-if="source.links && source.links.length">
        <div bbn-for="(l, idx) in source.links"
             :class="['bbn-spadded', {
               'link-progress': l.inProgress && !l.error,
               'link-success': !l.inProgress && !l.error,
               'link-error': l.error,
               'bbn-bordered-top': idx > 0
             }]">
          <div class="bbn-flex-width">
            <div bbn-if="imageDom"
                 class="appui-note-forum-link-image">
              <img bbn-if="l.image"
                   :src="imageDom + ref + '/' + l.image">
              <i bbn-else class="nf nf-fa-link"> </i>
            </div>
            <div class="appui-note-forum-link-title bbn-flex-fill">
              <strong>
                <a :href="l.content.url"
                   bbn-text="l.title || l.content.url"/>
              </strong>
              <br>
              <span bbn-if="l.content && l.content.description"
                    bbn-text="l.content.description"/>
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
      <bbn-checkbox bbn-model="source.important"
                    :value="1"
                    :novalue="0"/>
    </div>
    <template bbn-if="canLock">
      <label><?= _("Locked") ?></label>
      <div>
        <bbn-checkbox bbn-model="source.locked"
                      :value="1"
                      :novalue="0"/>
      </div>
    </template>
  </div>
</bbn-form>
