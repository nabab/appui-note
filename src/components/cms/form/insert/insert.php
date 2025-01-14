<!-- HTML Document -->
<bbn-form class="<?= $componentName ?>"
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
    <appui-note-field-url :source="formData"
                          :prefix="prefix"
                          bbn-model="formData.url"/>

    <label class="bbn-b">
      <?= _('Article type') ?>
    </label>
    <div class="bbn-flex-width">
      <bbn-dropdown bbn-model="formData.type"
                    :source="types"
                    class="bbn-flex-fill bbn-right-sspace"
                    :required="true"
                    source-value="id"/>
      <bbn-button icon="nf nf-fa-plus"
                  :notext="true"
                  :label="_('Add')"
                  @click="addCategory"/>
    </div>

    <label class="bbn-b">
      <?= _('Language') ?>
    </label>
    <bbn-dropdown bbn-model="formData.lang"
                  :source="['en', 'fr']"
                  :required="true"/>

    <label class="bbn-b">
      <?= _('Excerpt') ?>
    </label>
    <bbn-textarea bbn-model="formData.excerpt"
                  style="height: 10em; max-height: 20vh"/>

  </div>
</bbn-form>
