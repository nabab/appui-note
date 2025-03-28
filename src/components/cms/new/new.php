<!-- HTML Document -->

<bbn-form :class="[componentClass]"
          :action="source.url"
          :source="formData"
          @success="afterSubmit"
          :prefilled="true">
  <div class="bbn-grid-fields bbn-lpadding bbn-lg">
    <label class="bbn-b">
      <?= _('Title') ?>
    </label>
    <bbn-input bbn-model="formData.title"
               class="bbn-w-100"
               :required="true"/>

    <label class="bbn-b">
      <?= _('URL') ?>
    </label>
    <appui-note-cms-url :source="formData"
                        :pref="pref"/>

    <label class="bbn-b">
      <?= _('Article type') ?>
    </label>
    <bbn-dropdown bbn-model="formData.type"
                  :source="types"
                  class="bbn-w-100"
                  :required="true"/>

    <label class="bbn-b">
      <?= _('Language') ?>
    </label>
    <bbn-dropdown bbn-model="formData.lang"
                  :source="['en', 'fr']"
                  :required="true"/>
  </div>
</bbn-form>
