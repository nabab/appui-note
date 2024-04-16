<!-- HTML Document -->
<bbn-form :source="source"
          :class="componentClass"
          :data="{
                 ref: ref,
                 action: isEdit ? 'edit' : 'insert'
                 }"
          :scrollable="false"
          :action="url"
          @success="success"
          ref="form">
  <div class="bbn-grid-fields bbn-padded">

    <label><?= _('Title') ?></label>
    <bbn-input bbn-model="source.title"/>

    <label class="bbn-bottom-space"><?= _('Description') ?></label>
    <bbn-textarea bbn-model="source.description"
                  class="bbn-bottom-space"/>

    <label><?= _("Tags") ?></label>
    <bbn-values bbn-model="source.tags"/>

    <label><?= _('File') ?></label>
    <div>
      <span bbn-text="source.name"/>
      (<span bbn-text="formattedSize"/>)
      <span bbn-text="source.mimetype"
            class="bbn-left-space"/>

      <!--bbn-upload :json="asJson"
                  :paste="true"
                  bbn-model="currentFiles"
                  :multiple="false"
                  :save-url="root + 'media/actions/upload_save/' + ref"
                  @beforeremove="onRemove"
                  :remove-url="root + 'media/actions/delete_file/'+ ref"
                  :data="{
                         ref: ref,
                         id: source.id
                         }"/-->
    </div>

    <label><?= _('URL') ?></label>
    <div bbn-text="source.url"/>

    <template bbn-if="source.url">
      <label>
        <i class="bbn-p bbn-red nf nf-fa-trash"
           @click="clearCache(source.url, true)"
           title="<?= _('Clear all cache') ?>"
           bbn-if="!!source.cacheFiles && source.cacheFiles.length > 1"/>
        <span><?= _('Cache') ?></span>
      </label>
      <div class="bbn-grid-fields"
           style="grid-column-gap: 0.5rem">
        <template bbn-for="f in source.cacheFiles">
          <i class="bbn-p bbn-red nf nf-fa-trash"
             @click="clearCache(f.file, false)"
             title="<?= _('Remove') ?>"/>
          <div>
            <span bbn-text="f.name"
                  :title="f.name"/>
            <span class="bbn-s bbn-i">({{fdatetime(f.modified)}})</span>
          </div>
        </template>
      </div>
    </template>
  </div>
</bbn-form>
