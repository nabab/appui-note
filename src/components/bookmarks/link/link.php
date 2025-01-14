<bbn-form :prefilled="true"
          :validation="folder"
          class="bookmarks-form-link"
          :buttons="[]"
>
  <div class="bbn-grid-fields info-container">
    <bbn-input class="bbn-grid-full"
               type="hidden"
               :value="parent"/>
    <div class="bbn-grid-full">
      <i class="nf nf-fa-times bbn-p"
         bbn-if="parent !== 'ROOT'"
         @click="removeParent"
         title="<?= _("Create the link at root") ?>"/>
      <span class="bbn-green bbn-b"
            bbn-text="formHeader"/>
    </div>
    <div>
      <span><?= _("Text") ?></span>
    </div>
    <div>
      <bbn-input ref="text"
                placeholder="<?= _("Link title") ?>"
                class="bbn-w-100"
                bbn-model="source.text"/>
    </div>
    <div>
      <span><?= _("Description") ?></span>
    </div>
    <div>
      <bbn-textarea class="bbn-w-100"
                    style="width:100%"
                    bbn-model="source.description"/>
    </div>
    <div>
      <span><?= _("Url") ?></span>
    </div>
    <div>
      <bbn-input ref="link"
                 @keydown.enter.prevent.stop="linkEnter"
                 placeholder="<?= _("Type or paste your URL and press Enter to valid") ?>"
                 class="bbn-w-100"
                 bbn-model="source.url"/>
    </div>
    <div class="appui-note-bookmarks-links-container bbn-widget bbn-grid-full"
         ref="linksContainer"
         bbn-if="source.image"
         :style="link  ? 'border:1px solid' : 'border:none'"
    >
      <div :class="['bbn-file', {
              'link-progress': source.image.inProgress && !source.image.error,
              'link-success': !source.image.inProgress && !source.image.error,
              'link-error': source.image.error
            }]"
      >
        <div class="bbn-flex-width">
          <div bbn-if="imageDom && source.image.image"
               class="appui-note-bookmarks-link-image"
          >
            <img :src="imageDom + ( source.image.img_path ? source.image.img_path : ref ) + '/' + source.image.image"
            >
          </div>
           <div bbn-else class="appui-note-bookmarks-link-noimage">
            <i class="nf nf-fa-link bbn-xl"></i>
          </div>
          <div class="appui-note-bookmarks-link-title bbn-flex-fill">
            <strong>
              <a :href="source.image.content.url"
                  class="bbn-p"
                  bbn-text="source.image.content.url"
              ></a>
            </strong>
            <br>
            <span bbn-if="source.image.content && source.image.content.description"
                  bbn-text="source.image.content.description"
            ></span>
          </div>
          <div class="appui-note-bookmarks-link-actions bbn-vmiddle">
            <bbn-button class=""
                        style="display: inline-block;"
                        @click="linkRemove"
                        icon="nf nf-fa-times"
                        title="<?= _('Remove') ?>"/>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="bbn-l bbn-padding">
    <bbn-button label="<?= _("Cancel") ?>"
                icon="nf nf-fa-times"
                @click="closeForm"/>
    <bbn-button label="<?= _("Save") ?>"
                icon="nf nf-fa-check"
                @click="submit"/>
  </div>
</bbn-form>