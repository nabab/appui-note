<!-- HTML Document -->

<div :class="componentClass">
  <div class="bbn-grid-fields bbn-padded">
    <div class="bbn-grid-full bbn-c">
      <h3>
        <?= _("General Information") ?>
      </h3>
    </div>

    <div><?= _("Filename") ?>:</div>
    <div v-text="source.name"
         class="bbn-b"/>

    <div style="min-width: 8em"><?= _("Title") ?></div>
    <div v-text="source.title"
         class="bbn-b"/>

    <div v-if="source.description"><?= _("Description") ?></div>
    <div v-if="source.description"
         v-text="source.description"/>

    <div><?= _("MIME type") ?></div>
    <div v-text="source.mimetype"/>

    <div><?= _("User") ?></div>
    <div v-text="getField(users, 'text', {value: source.id_user})"/>

    <div><?= _("Size") ?></div>
    <div v-text="formatBytes(source.content.size)"/>

    <div><?= _("Extension") ?></div>
    <div v-text="source.content.extension"/>

    <div class="bbn-grid-full bbn-c">
      <hr>
      <h3>
        <?= _("Internal Information") ?>
      </h3>
    </div>

    <div v-if="source.path"><?= _("URL") ?></div>
    <div v-if="source.path"
         class="bbn-nowrap">
      <bbn-button text="<?= _("Copy") ?>"
                  icon="nf nf-fa-copy"
                  :notext="true"
                  @click="copyPath"/>
      <a :href="source.path"
         target="_blank"
         class="bbn-iblock"
         style="text-overflow: ellipsis; max-width: 20em; white-space: nowrap; overflow: hidden"
         :title="source.path"
         v-text="source.path"/>
    </div>

    <div><?= _("Real path") ?></div>
    <div class="bbn-nowrap">
      <bbn-button text="<?= _("Copy") ?>"
                  icon="nf nf-fa-copy"
                  :notext="true"
                  @click="copyFile"/>
      <span class="bbn-iblock"
            style="text-overflow: ellipsis; max-width: 20em; white-space: nowrap; overflow: hidden"
            :title="source.file"
            v-text="source.file"/>
    </div>

    <div><?= _("ID") ?></div>
    <div class="bbn-nowrap">
      <bbn-button text="<?= _("Copy") ?>"
                  icon="nf nf-fa-copy"
                  :notext="true"
                  @click="copyId"/>
      <span class="bbn-iblock"
            style="text-overflow: ellipsis; max-width: 20em; white-space: nowrap; overflow: hidden"
            :title="source.id"
            v-text="source.id"/>
    </div>

    <div v-if="source.url">
      <span><?= _('Cache') ?></span>
      <bbn-button class="bbn-bg-red bbn-white"
                  icon="nf nf-fa-trash"
                  :notext="true"
                  @click="clearCache(source.url, true)"
                  title="<?= _('Clear all cache') ?>"
                  v-if="!!source.cacheFiles && source.cacheFiles.length > 1"/>
    </div>
    <div class="bbn-nowrap bbn-grid-fields"
         style="grid-column-gap: 0.5rem">
      <template v-for="f in source.cacheFiles">
          <bbn-button class="bbn-bg-red bbn-white"
                      icon="nf nf-fa-trash"
                      :notext="true"
                      @click="clearCache(f.file, false)"
                      title="<?= _('Remove') ?>"/>
          <div>
            <span class="bbn-s bbn-i">({{fdatetime(f.modified)}})</span>
            <span v-text="f.name"
                  :title="f.name"/>
          </div>
        </template>
    </div>

    <template v-if="source.is_image">
      <div class="bbn-grid-full bbn-c">
        <hr>
        <h3>
          <?= _("Image Information") ?>
        </h3>
      </div>

      <div v-if="source.dimensions"><?= _("Dimensions") ?></div>
      <div v-if="source.dimensions"
           v-text="source.dimensions.w + ' px x ' + source.dimensions.h + ' px'"/>

      <div v-if="source.thumbs"><?= _("Thumbnails") ?></div>
      <div v-if="source.thumbs">
        <span v-for="t in source.thumbs"
              class="bbn-right-sspace"
              v-text="t + ' px'"/>
      </div>

      <div v-if="hasImage"
           class="bbn-grid-full bbn-c bbn-vpadded">
        <img :src="imageSrc">
      </div>

    </template>

    <div class="bbn-grid-full bbn-c">
      <bbn-button @click="openDetails">
        <?= _("Show details") ?>
      </bbn-button>
    </div>

    <div class="bbn-grid-full bbn-bordered bbn-radius bbn-spadded bbn-vmargin"
         v-for="n in source.notes">
      <div class="bbn-grid-fields">
        <div><?= _("Note title") ?></div>
        <div v-text="n.title"></div>

        <div><?= _("Creation") ?></div>
        <div v-text="n.creation"></div>

        <div><?= _("Version") ?></div>
        <div v-text="n.version"></div>

        <div><?= _("Published") ?></div>
        <div v-text="n.is_published ? _('Yes') : _('No') "></div>

        <div><?= _("Content") ?></div>
        <i class="nf nf-mdi-comment_text bbn-medium bbn-p"
           title="<?= _("Note content") ?>"
           @click="show_note_content(n)"/>
      </div>
    </div>
  </div>
</div>
