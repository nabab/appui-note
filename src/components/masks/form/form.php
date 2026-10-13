<bbn-form :source="source"
          ref="form"
          @success="success"
          :action="action"
          class="appui-note-masks-form bbn-overlay"
          :scrollable="false">
  <appui-note-toolbar-version bbn-if="source.hasVersions"
                              :source="source"
                              :data="{id: source.id_note}"
                              @version="getVersion"
                              :actionUrl="root + '/data/version'"/>
  <div class="bbn-padding bbn-grid-fields bbn-flex-fill"
       :style="currentStyle">
    <label bbn-if="emptyCategories?.length"><?= _('Type') ?></label>
    <bbn-dropdown bbn-if="emptyCategories?.length"
                  bbn-model="source.id_type"
                  :source="emptyCategories"
                  source-value="id"
                  :nullable="false"
                  :required="true"/>
    <label><?= _('Name') ?></label>
    <bbn-input bbn-model="source.name"
               :required="true"/>
    <label><?= _('Object') ?></label>
    <bbn-input bbn-model="source.title"
               :required="true"/>
    <template bbn-if="availableFields?.length">
      <label><?= _('Available fields') ?></label>
      <appui-note-masks-form-fields :source="availableFields"/>
    </template>
    <label><?= _('Text') ?></label>
    <div class="bbn-h-100">
      <div class="bbn-overlay">
        <bbn-rte bbn-model="source.content"
                 ref="editor"
                 :required="true"
                 height="100%"/>
      </div>
    </div>
  </div>
</bbn-form>