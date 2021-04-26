<div class="bbn-overlay">
  <bbn-form :action="root + 'actions/form/insert'"
            :source="formData"
            :scrollable="true"
            @success="afterSubmit">
    <div class="bbn-padded bbn-grid-fields">
      <label><?=_('Type')?></label>
      <div>
        <bbn-dropdown v-model="formData.id_type"
                      :source="source.types"
                      :required="true"/>
      </div>
      <label><?=_('Title')?></label>
      <bbn-input v-model="formData.title"
                 :required="true"/>
      <div class="bbn-label">
        <label><?=_('Content')?></label>
        <br>
        <bbn-dropdown :source="editors"
                      v-model="editor"/>
      </div>
      <component :is="editor"
                  v-model="formData.content"
                  style="min-height: 300px"
                  :required="true"/>
      <label><?=_('Mime')?></label>
      <bbn-input v-model="formData.mime"/>
      <label><?=_('lang')?></label>
      <div>
        <bbn-dropdown v-if="languages"
                      :source="languages"
                      v-model="formData.lang"/>
        <bbn-input v-else
                   v-model="formData.lang"
                   style="width: 2em"
                   maxlength="2"/>
      </div>
      <label><?=_('Private')?></label>
      <bbn-checkbox v-model="formData.private"
                    :value="1"
                    :novalue="0"/>
      <label><?=_('Locked')?></label>
      <bbn-checkbox v-model="formData.locked"
                    :value="1"
                    :novalue="0"/>
      <label><?=_('Pinned')?></label>
      <bbn-checkbox v-model="formData.pinned"
                    :value="1"
                    :novalue="0"/>
      <label><?=_('URL')?></label>
      <bbn-input v-model="formData.url"/>
      <label><?=_('Start')?></label>
      <div>
        <bbn-datetimepicker v-model="formData.start"/>
      </div>
      <label><?=_('End')?></label>
      <div>
        <bbn-datetimepicker v-model="formData.end"
                      :disabled="!formData.start"
                      :min="formData.start"/>
      </div>
    </div>
  </bbn-form>
</div>