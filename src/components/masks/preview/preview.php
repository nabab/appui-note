<div class="appui-note-masks-preview bbn-padding bbn-block">
  <bbn-form bbn-if="hasInputs"
            :windowed="false"
            :buttons="['cancel', 'submit']"
            mode="small"
            class="bbn-secondary-border bbn-radius"
            :source="inputsSource"
            @submit="onSubmit"
            @cancel="onCancel">
    <div class="bbn-radius-top bbn-secondary bbn-xspadding bbn-c bbn-m bbn-upper">
      <?=_("Enter the required values to make the necessary data")?>
    </div>
    <div class="bbn-grid-fields bbn-hpadding bbn-top-padding">
      <template bbn-for="input in inputs">
        <div class="bbn-label"
             bbn-html="input.label"/>
        <component :is="input.component"
                   bbn-model="inputsSource[input.field]"
                   :required="input.required"/>
      </template>
    </div>
  </bbn-form>
  <div bbn-if="showPreview"
       class="bbn-tertiary-border bbn-radius bbn-top-space">
    <div class="bbn-radius-top bbn-tertiary bbn-xspadding bbn-c bbn-m bbn-upper">
      <?=_("Preview")?>
    </div>
    <bbn-frame :url="previewUrl"
               class="bbn-w-100 bbn-radius-bottom bbn-spadding"
               style="min-height: 30rem"
               :security="false"/>
  </div>
</div>