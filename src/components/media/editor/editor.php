<!-- HTML Document -->

<bbn-form :source="source"
          :class="componentClass"
          :data="{
                 ref: ref,
                 action: isEdit ? 'edit' : 'insert'
                 }"
          :scrollable="false"
          :action="url"
          @success="success">
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
  </div>
</bbn-form>
