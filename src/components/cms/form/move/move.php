<bbn-form :source="formData"
          :action="cp.moveUrl"
          @success="onSuccess"
          class="appui-note-cms-form-move">
  <div class="bbn-padded bbn-grid-fields">
    <label class="bbn-label"><?=_('Category')?></label>
    <bbn-dropdown placeholder="<?=_('Choose')?>"
                  :source="cp.typesTextValue"
                  v-model="formData.type"/>
  </div>
</bbn-form>
