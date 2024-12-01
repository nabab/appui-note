<div class="bbn-overlay">
  <bbn-form :action="root + 'actions/form/insert'"
            :source="formData"
            :scrollable="true"
            @success="afterSubmit">
    <div class="bbn-padding bbn-grid-fields">
      <label><?= _('Type') ?></label>
      <div>
        <bbn-dropdown bbn-model="formData.id_type"
                      :source="source.types"
                      :required="true"/>
      </div>
      <label><?= _('Title') ?></label>
      <bbn-input bbn-model="formData.title"
                 :required="true"/>
      <div class="bbn-label">
        <label><?= _('Content') ?></label>
        <br>
        <bbn-dropdown :source="editors"
                      bbn-model="editor"/>
      </div>
      <component :is="editor"
                  bbn-model="formData.content"
                  style="min-height: 300px"
                  :required="true"/>
      <label><?= _('Mime') ?></label>
      <bbn-input bbn-model="formData.mime"/>
      <label><?= _('lang') ?></label>
      <div>
        <bbn-dropdown bbn-if="languages"
                      :source="languages"
                      bbn-model="formData.lang"/>
        <bbn-input bbn-else
                   bbn-model="formData.lang"
                   style="width: 2em"
                   maxlength="2"/>
      </div>
      <label><?= _('Private') ?></label>
      <bbn-checkbox bbn-model="formData.private"
                    :value="1"
                    :novalue="0"/>
      <label><?= _('Locked') ?></label>
      <bbn-checkbox bbn-model="formData.locked"
                    :value="1"
                    :novalue="0"/>
      <label><?= _('Pinned') ?></label>
      <bbn-checkbox bbn-model="formData.pinned"
                    :value="1"
                    :novalue="0"/>
      <label><?= _('URL') ?></label>
      <bbn-input bbn-model="formData.url"/>
      <label><?= _('Start') ?></label>
      <div>
        <bbn-datetimepicker bbn-model="formData.start"/>
      </div>
      <label><?= _('End') ?></label>
      <div>
        <bbn-datetimepicker bbn-model="formData.end"
                      :disabled="!formData.start"
                      :min="formData.start"/>
      </div>
    </div>
  </bbn-form>
</div>