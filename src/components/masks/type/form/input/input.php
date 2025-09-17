<bbn-form :windowed="false"
          class="appui-note-masks-type-form-input bbn-radius bbn-secondary-border"
          mode="small"
          :source="formSource"
          @success="$emit('success', formSource)"
          :buttons="['submit']">
  <div class="bbn-grid-fields bbn-spadding">
    <div class="bbn-label"><?=_("Field")?></div>
    <bbn-input bbn-model="formSource.field"
               :required="true"/>
    <div class="bbn-label"><?=_("Label")?></div>
    <bbn-input bbn-model="formSource.label"
               :required="true"/>
    <div class="bbn-label"><?=_("Component")?></div>
    <bbn-input bbn-model="formSource.component"
               :required="true"/>
    <div class="bbn-label"><?=_("Required")?></div>
    <bbn-switch bbn-model="formSource.required"
                :value="1"
                :novalue="0"/>
  </div>
</bbn-form>