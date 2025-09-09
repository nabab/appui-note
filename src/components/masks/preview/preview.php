<div class="appui-note-masks-preview bbn-padding bbn-block">
  <bbn-form bbn-if="hasInputs"
            :windowed="false"
            :buttons="['cancel', 'submit']"
            mode="small"
            class="bbn-secondary-border bbn-radius"
            :source="inputsSource"
            @submit="onSubmit">
    <div class="bbn-radius-top bbn-secondary bbn-xspadding bbn-c bbn-m bbn-upper">
      <?=_("Enter the required values to find the necessary data")?>
    </div>
    <div class="bbn-grid-fields bbn-hpadding bbn-top-padding">
      <template bbn-for="(input, field) in model.inputs">
        <div class="bbn-label"
             bbn-html="input.label"/>
        <component :is="input.component"
                   bbn-model="inputsSource[field]"
                   :required="input.required"/>
      </template>
    </div>
  </bbn-form>
  <bbn-frame bbn-if="showPreview"
             :url="previewUrl"/>
</div>