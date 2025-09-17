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
      <div bbn-if="formSource.preview === 'custom'"
            class="bbn-label">
        <span><?=_("Inputs")?></span>
        <bbn-button :notext="true"
                    :icon="isAddingInput || isEditingInput ? 'nf nf-fa-close' : 'nf nf-fa-plus'"
                    :title="isAddingInput || isEditingInput ? _('Close form') : _('Add input')"
                    @click="isEditingInput ? (isEditingInput = false) : (isAddingInput = !isAddingInput)"/>
      </div>
      <div bbn-if="formSource.preview === 'custom'">
        <template bbn-if="!isAddingInput && !formSource.preview_inputs.length">
          <bbn-icon content="nf nf-fa-arrow_left_long bbn-light bbn-left-xsspace"/>
          <span><?=_("Add a new input")?></span>
        </template>
        <appui-note-masks-type-form-input bbn-if="isAddingInput || isEditingInput"
                                          :source="isEditingInput || {}"
                                          @success="onInputSaved"/>
        <div bbn-elseif="formSource.preview_inputs.length"
             class="bbn-flex-wrap bbn-grid-xsgap">
          <div bbn-for="input in formSource.preview_inputs"
               class="bbn-spadding bbn-radius bbn-background-secondary bbn-secondary-text bbn-grid"
               style="grid-template-columns: auto max-content; align-items: center; gap: var(--xsspace)">
            <span bbn-text="input.field"/>
            <div>
              <i class="nf nf-fa-pencil bbn-p bbn-alt-background bbn-alt-text bbn-radius bbn-xspadding"
                 @click="isEditingInput = input"/>
              <i class="nf nf-fa-trash bbn-p bbn-bg-red bbn-white bbn-radius bbn-xspadding"
                 @click="isEditingInput = input"/>
            </div>
          </div>
        </div>
      </div>
      <div bbn-if="formSource.preview === 'custom'"
            class="bbn-label">
        <span><?=_("Fields")?></span>
        <bbn-button :notext="true"
                    :icon="isAddingField || isEditingField ? 'nf nf-fa-close' : 'nf nf-fa-plus'"
                    :title="isAddingField || isEditingField ? _('Close form') : _('Add field')"
                    @click="isEditingField ? (isEditingField = false) : (isAddingField = !isAddingField)"/>
      </div>
      <div bbn-if="formSource.preview === 'custom'">
        <template bbn-if="!isAddingField && !formSource.fields.length">
          <bbn-icon content="nf nf-fa-arrow_left_long bbn-light bbn-left-xsspace"/>
          <span><?=_("Add a new field")?></span>
        </template>
        <appui-note-masks-type-form-field bbn-if="isAddingField || isEditingField"
                                          :source="isEditingField || {}"
                                          @success="onFieldSaved"/>
        <div bbn-elseif="formSource.fields.length"
             class="bbn-flex-wrap bbn-grid-xsgap">
          <div bbn-for="field in formSource.fields"
               class="bbn-spadding bbn-radius bbn-background-secondary bbn-secondary-text bbn-grid"
               style="grid-template-columns: auto max-content; align-items: center; gap: var(--xsspace)">
            <span bbn-text="field.field"/>
            <div>
              <i class="nf nf-fa-pencil bbn-p bbn-alt-background bbn-alt-text bbn-radius bbn-xspadding"
                 @click="isEditingField = field"/>
              <i class="nf nf-fa-trash bbn-p bbn-bg-red bbn-white bbn-radius bbn-xspadding"
                 @click="isEditingField = field"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</bbn-form>