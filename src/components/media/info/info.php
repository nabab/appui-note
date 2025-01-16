<!-- HTML Document -->

<div :class="componentClass">
  <div class="bbn-grid-fields bbn-padding">
    <div class="bbn-grid-full bbn-c">
      <h3>
        <?= _("General Information") ?>
      </h3>
    </div>

    <div><?= _("Filename") ?>:</div>
    <div bbn-text="source.name"
         class="bbn-b"/>

    <div style="min-width: 8em"><?= _("Title") ?></div>
    <div bbn-text="source.title"
         class="bbn-b"/>

    <div bbn-if="source.description"><?= _("Description") ?></div>
    <div bbn-if="source.description"
         bbn-text="source.description"/>

    <div><?= _("MIME type") ?></div>
    <div bbn-text="source.mimetype"/>

    <div><?= _("User") ?></div>
    <div bbn-text="getField(users, 'text', {value: source.id_user})"/>

    <div><?= _("Size") ?></div>
    <div bbn-text="formatBytes(source.content.size)"/>

    <div><?= _("Extension") ?></div>
    <div bbn-text="source.content.extension"/>

    <div class="bbn-grid-full bbn-c">
      <hr>
      <h3>
        <?= _("Internal Information") ?>
      </h3>
    </div>

    <div bbn-if="source.path"><?= _("URL") ?></div>
    <div bbn-if="source.path"
         class="bbn-nowrap">
      <bbn-button label="<?= _("Copy") ?>"
                  icon="nf nf-fa-copy"
                  :notext="true"
                  @click="copyPath"/>
      <a :href="source.path"
         target="_blank"
         class="bbn-iblock"
         style="text-overflow: ellipsis; max-width: 20em; white-space: nowrap; overflow: hidden"
         :title="source.path"
         bbn-text="source.path"/>
    </div>

    <div><?= _("Real path") ?></div>
    <div class="bbn-nowrap">
      <bbn-button label="<?= _("Copy") ?>"
                  icon="nf nf-fa-copy"
                  :notext="true"
                  @click="copyFile"/>
      <span class="bbn-iblock"
            style="text-overflow: ellipsis; max-width: 20em; white-space: nowrap; overflow: hidden"
            :title="source.file"
            bbn-text="source.file"/>
    </div>

    <div><?= _("ID") ?></div>
    <div class="bbn-nowrap">
      <bbn-button label="<?= _("Copy") ?>"
                  icon="nf nf-fa-copy"
                  :notext="true"
                  @click="copyId"/>
      <span class="bbn-iblock"
            style="text-overflow: ellipsis; max-width: 20em; white-space: nowrap; overflow: hidden"
            :title="source.id"
            bbn-text="source.id"/>
    </div>

    <div bbn-if="source.url">
      <span><?= _('Cache') ?></span>
      <bbn-button class="bbn-bg-red bbn-white"
                  icon="nf nf-fa-trash"
                  :notext="true"
                  @click="clearCache(source.url, true)"
                  title="<?= _('Clear all cache') ?>"
                  bbn-if="!!source.cacheFiles && source.cacheFiles.length > 1"/>
    </div>
    <div class="bbn-nowrap bbn-grid-fields"
         style="grid-column-gap: 0.5rem">
      <template bbn-for="f in source.cacheFiles">
          <bbn-button class="bbn-bg-red bbn-white"
                      icon="nf nf-fa-trash"
                      :notext="true"
                      @click="clearCache(f.file, false)"
                      title="<?= _('Remove') ?>"/>
          <div>
            <span class="bbn-s bbn-i">({{fdatetime(f.modified)}})</span>
            <span bbn-text="f.name"
                  :title="f.name"/>
          </div>
        </template>
    </div>

    <template bbn-if="source.is_image">
      <div class="bbn-grid-full bbn-c">
        <hr>
        <h3>
          <?= _("Image Information") ?>
        </h3>
      </div>

      <div bbn-if="source.dimensions"><?= _("Dimensions") ?></div>
      <div bbn-if="source.dimensions"
           bbn-text="source.dimensions.w + ' px x ' + source.dimensions.h + ' px'"/>

      <div bbn-if="source.thumbs"><?= _("Thumbnails") ?></div>
      <div bbn-if="source.thumbs">
        <span bbn-for="t in source.thumbs"
              class="bbn-right-sspace"
              bbn-text="t + ' px'"/>
      </div>

      <div bbn-if="hasImage"
           class="bbn-grid-full bbn-c bbn-vpadding">
        <img :src="imageSrc">
      </div>

    </template>

    <div class="bbn-grid-full bbn-c">
      <bbn-button @click="openDetails">
        <?= _("Show details") ?>
      </bbn-button>
    </div>

    <div class="bbn-grid-full bbn-border bbn-radius bbn-spadding bbn-vmargin"
         bbn-for="n in source.notes">
      <div class="bbn-grid-fields">
        <div><?= _("Note title") ?></div>
        <div bbn-text="n.title"></div>

        <div><?= _("Creation") ?></div>
        <div bbn-text="n.creation"></div>

        <div><?= _("Version") ?></div>
        <div bbn-text="n.version"></div>

        <div><?= _("Published") ?></div>
        <div bbn-text="n.is_published ? _('Yes') : _('No') "></div>

        <div><?= _("Content") ?></div>
        <i class="nf nf-md-comment_text bbn-medium bbn-p"
           title="<?= _("Note content") ?>"
           @click="show_note_content(n)"/>
      </div>
    </div>
  </div>
</div>
