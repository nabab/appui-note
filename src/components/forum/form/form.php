<bbn-form class="appui-note-forum-form"
          :action="source.props.formAction"
          :source="source.row"
					:data="data"
          @success="source.props.formSuccess">
  <appui-note-toolbar-version v-if="data.id && source.row.hasVersions"
                               :source="source.row"
                               :data="data"
                               @version="changeVersion"/>
  <div class="bbn-grid-fields bbn-padded">
    <label v-if="source.row.title !== undefined">
      <?= _("Title") ?>
    </label>
    <bbn-input v-if="source.row.title !== undefined"
							 v-model="source.row.title"/>

    <label v-if="(source.row.category !== undefined) && source.props.categories">
      <?= _("Category") ?>
    </label>
    <bbn-dropdown v-if="(source.row.category !== undefined) && source.props.categories"
                  required="required"
                  v-model="source.row.category"
                  :source="source.props.categories"/>

    <div style="text-align: right">
      <div><?= _("Text") ?></div>
      <!--<br>
      <bbn-dropdown :source="editorTypes"
                    ref="editorType"
                    @change="switchEditorType"
      ></bbn-dropdown>-->
    </div>
    <div>
      <div class="bbn-w-100">
        <component :is="editorType"
                  ref="editor"
                  v-model="source.row.text"
                  style="min-height: 450px; width: 100%;"
                  required="required"
                  class="bbn-w-100"
                  height="450px"/>
      </div>
    </div>

    <label v-if="fileSave && fileRemove">
      <?= _("Files") ?>
    </label>
    <div v-if="fileSave && fileRemove"
         class="bbn-task-files-container">
      <bbn-upload :save-url="fileSave + data.ref"
                  :remove-url="fileRemove + data.ref"
                  v-model="source.row.files"
                  :paste="true"
                  :show-filesize="false"/>
    </div>

    <label>
      <?= _("Links") ?>
    </label>
    <div>
      <div class="bbn-w-100">
        <bbn-input ref="link"
                   @keydown.enter.prevent.stop="linkEnter"
                   placeholder="<?= _("Type or paste your URL and press Enter to valid") ?>"
                   class="bbn-w-100"/>
      </div>
      <div class="appui-note-forum-links-container bbn-widget bbn-w-100"
           ref="linksContainer"
           v-if="source.row.links && source.row.links.length">
        <div v-for="(l, idx) in source.row.links"
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
                   :src="imageDom + data.ref + '/' + l.image">
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
                          title="<?=_('Remove')?>"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <label v-if="canLock">
      <?= _("Locked") ?>
    </label>
    <div>
      <bbn-checkbox v-if="canLock"
                    v-model="source.row.locked"
                    :value="1"
                    :novalue="0"/>
    </div>
  </div>
</bbn-form>
