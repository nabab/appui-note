<bbn-form class="appui-note-masks-type-form"
          :action="root + 'actions/masks/category'"
          @success="onSuccess"
          @failure="onFailre"
          :source="formSource">
  <div class="bbn-grid-fields bbn-hpadding bbn-top-padding">
    <div class="bbn-label"><?=_("Name")?></div>
    <bbn-input bbn-model="formSource.name"
               :required="true"/>
    <div class="bbn-label"><?=_("Code")?></div>
    <bbn-input bbn-model="formSource.code"
               :required="true"/>
  </div>
  <div class="bbn-section">
    <div class="bbn-legend"><?=_("Preview")?></div>
    <div class="bbn-grid-fields ">
      <div class="bbn-label"><?=_("Type")?></div>
      <bbn-dropdown bbn-model="formSource.preview"
                    :source="previewTypes"
                    :required="true"/>
      <div bbn-if="formSource.preview === 'model'"
            class="bbn-label">
        <?=_("Model")?>
      </div>
      <bbn-dropdown bbn-if="formSource.preview === 'model'"
                    bbn-model="formSource.preview_model"
                    :source="root + 'data/masks/models'"
                    :required="true"
                    source-value="id"
                    source-text="name"/>
    </div>
  </div>
</bbn-form>