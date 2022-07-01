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

    <label><?=_('Title')?></label>
    <bbn-input v-model="source.title"/>

    <label class="bbn-bottom-space"><?=_('Description')?></label>
    <bbn-textarea v-model="source.description"
                  class="bbn-bottom-space"/>

    <label><?= _("Tags") ?></label>
    <bbn-values v-model="source.tags"/>

    <label><?=_('File')?></label>
    <div>
      <span v-text="source.name"/>
      (<span v-text="formattedSize"/>)
      <span v-text="source.mimetype"
            class="bbn-left-space"/>

      <!--bbn-upload :json="asJson"
                  :paste="true"
                  v-model="currentFiles"
                  :multiple="false"
                  :save-url="root + 'media/actions/upload_save/' + ref"
                  @beforeRemove="onRemove"
                  :remove-url="root + 'media/actions/delete_file/'+ ref"
                  :data="{
                         ref: ref,
                         id: source.id
                         }"/-->
    </div>

    <label><?=_('URL')?></label>
    <div v-text="source.url"/>

    <template v-if="source.url">
      <label>
        <i class="bbn-p bbn-red nf nf-fa-trash"
           @click="clearCache(source.url, true)"
           title="<?=_('Clear all cache')?>"
           v-if="!!source.cacheFiles && source.cacheFiles.length > 1"/>
        <span><?=_('Cache')?></span>
      </label>
      <div class="bbn-grid-fields"
           style="grid-column-gap: 0.5rem">
        <template v-for="f in source.cacheFiles">
          <i class="bbn-p bbn-red nf nf-fa-trash"
             @click="clearCache(f.file, false)"
             title="<?=_('Remove')?>"/>
          <div>
            <span v-text="f.name"
                  :title="f.name"/>
            <span class="bbn-s bbn-i">({{fdatetime(f.modified)}})</span>
          </div>
        </template>
      </div>
    </template>
  </div>
</bbn-form>
