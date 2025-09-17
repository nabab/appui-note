<bbn-form :windowed="false"
          class="appui-note-masks-type-form-field bbn-radius bbn-tertiary-border"
          mode="small"
          :source="formSource"
          @success="$emit('success', formSource)"
          :buttons="['submit']"
          style="min-width: 30rem">
  <div class="bbn-grid-fields bbn-spadding">
    <div class="bbn-label"><?=_("Field")?></div>
    <bbn-input bbn-model="formSource.field"
               :required="true"/>
    <div class="bbn-label">
      <span><?=_("Items")?></span>
      <bbn-button :notext="true"
                  :icon="isAddingItem || isEditingItem ? 'nf nf-fa-close' : 'nf nf-fa-plus'"
                  :title="isAddingItem || isEditingItem ? _('Close form') : _('Add item')"
                  @click="isEditingItem ? (isEditingItem = false) : (isAddingItem = !isAddingItem)"/>
    </div>
    <div>
      <template bbn-if="!isAddingItem && !formSource.items.length">
        <bbn-icon content="nf nf-fa-arrow_left_long bbn-light bbn-left-xsspace"/>
        <span><?=_("Add a new item")?></span>
      </template>
      <appui-note-masks-type-form-field bbn-if="isAddingItem || isEditingItem"
                                        :source="isEditingItem || {}"
                                        @success="onItemSaved"/>
      <div bbn-elseif="formSource.items.length"
            class="bbn-flex-wrap bbn-grid-xsgap">
        <div bbn-for="item in formSource.items"
              class="bbn-spadding bbn-radius bbn-background-secondary bbn-secondary-text bbn-grid"
              style="grid-template-columns: auto max-content; align-items: center; gap: var(--xsspace)">
          <span bbn-text="item.field"/>
          <div>
            <i class="nf nf-fa-pencil bbn-p bbn-alt-background bbn-alt-text bbn-radius bbn-xspadding"
                @click="isEditingItem = item"/>
            <i class="nf nf-fa-trash bbn-p bbn-bg-red bbn-white bbn-radius bbn-xspadding"
                @click="isEditingItem = item"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</bbn-form>