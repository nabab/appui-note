<div class="bbn-overlay book-bottom" 
    
>
  <div class="bbn-w-100 bbn-padded">
    <bbn-button class="bbn-p"
                icon="nf nf-fa-trash "
                title="<?= _("Delete this link") ?>"
                @click="remove"
                :text="'<?= _("Delete this") ?>' + ' ' + selectedType"/>
    <bbn-button class="bbn-p"
                icon="nf nf-fa-edit "
                title="<?= _("Edit this link") ?>"
                @click="edit"
                :text="'<?= _("Edit this") ?>' + ' ' + selectedType"/>
  </div>
  <div bbn-if="selectedType === 'link'"
       class="bbn-grid-fields">
    <span bbn-if="source.showLink.path"
          class="bbn-green bbn-medium">
      <?= _("Path") ?>
    </span>
    <div bbn-if="source.showLink.path"
        class="bbn-green bbn-medium"
        bbn-text="(source.showLink.path !== '/') ? source.showLink.path : 'Root'"/>
    <span bbn-if="source.showLink.text"
          class="bbn-medium">
      <?= _("Text") ?>
    </span>
    <div bbn-if="source.showLink.text"
        bbn-text="source.showLink.text"
        class="bbn-medium"/>
    <span bbn-if="source.showLink.url"
          class="bbn-medium">
      <?= _("Url") ?>
    </span>
    <div class="bbn-medium">
      <a :src="renderUrl(source.showLink.url)"
          bbn-text="renderUrl(source.showLink.url)"
          class="bbn-p bbn-medium"/>
    </div>

    <span bbn-if="source.showLink.description"
          class="bbn-medium">
      <?= _("Description") ?>
    </span>
    <div bbn-if="source.showLink.description"
         bbn-text="source.showLink.description ? source.showLink.description : '' "
         class="bbn-medium"/>
    <div class="appui-note-bookmarks-links-container bbn-widget bbn-grid-full"
          ref="linksContainer"
          bbn-if="source.showLink.image"
          style="border:1px solid"
    >
      <div :class="['k-file', {
              'link-progress': source.showLink.image.inProgress && !source.showLink.image.error,
              'link-success': !source.showLink.image.inProgress && !source.showLink.image.error,
              'link-error': source.showLink.image.error
            }]"
      >
        <div class="bbn-flex-width">
          <div bbn-if="source.showLink.image.img_path && source.showLink.image.image"
              class="appui-note-bookmarks-link-image">
            <img :src="imageDom + source.showLink.image.img_path + source.showLink.image.image"
            >
          </div>
          <div bbn-else class="appui-note-bookmarks-link-noimage">
            <i class="nf nf-fa-link bbn-xl"></i>
          </div>
          <div class="appui-note-bookmarks-link-title bbn-flex-fill">
            <strong>
              <a :href="source.showLink.image.content.url"
                  class="bbn-p"
                  bbn-text="source.showLink.image.title || source.showLink.image.content.url"
              ></a>
            </strong>
            <br>
            <span bbn-if="source.showLink.image.content && source.showLink.image.content.description"
                  bbn-text="source.showLink.image.content.description"
            ></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div bbn-else-if="source.showFolder" class="bbn-grid-fields bbn-medium">
    <span bbn-if="source.showFolder.items && source.showFolder.items.length" 
          bbn-html="'The folder contains' + ' ' +'<span class=\'bbn-green\'>' + source.showFolder.items.length + 'items' + '</span>' "
          class="bbn-grid-full"
    ></span>
    <span bbn-else
          class="bbn-grid-full">
      <?= _("This folder is empty") ?>
    </span>
    <span><?= _("Folder name") ?></span>
    <span bbn-text="source.showFolder.text"/>
    <span><?= _("Parent") ?></span>
    <span bbn-text="source.showFolder.parent"/>
  </div>
</div>