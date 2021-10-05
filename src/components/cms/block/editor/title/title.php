<!-- HTML Document -->

<div :class="['component-container','bbn-cms-block-edit' ,'bbn-block-title', 'bbn-flex-height', {'has-hr': source.hr}, alignClass]">
  <div class="edit-title bbn-w-100">
    <bbn-textarea v-model="source.content"
                  style="min-width: 30em"
                  class="bbn-w-100 bbn-m"/>
  </div>
  <div class="bbn-grid-fields bbn-vspadded bbn-w-100">
    <label><?= _('Tag') ?></label>
    <div>
      <bbn-dropdown :source="tags"
                    v-model="source.tag"
                    :component="$options.components.tag">
      </bbn-dropdown>
    </div>

    <label><?= _('Color') ?></label>
    <div>
      <bbn-colorpicker v-model="color"/>
    </div>

    <label><?= _('Alignment') ?></label>
    <appui-note-cms-block-align :source="source"/>

    <label><?= _('Line') ?></label>
		<appui-note-cms-block-line :source ="source"/>
  </div>
</div>