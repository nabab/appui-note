<bbn-form :prefilled="true"
          :validation="folder"
          class="bbn-padded"
          :buttons="[]"
          >
  <div class="bbn-padded bbn-grid-fields">
    <div class="bbn-grid-full">
      <i class="nf nf-fa-times bbn-p"
         bbn-if="parent !== 'ROOT'"
         @click="removeParent"
         title="<?= _("Create the link at root") ?>"/>
      <span class="bbn-green bbn-b"
            bbn-text="( parent !== 'ROOT' ) ? '<?= _('Create the folder in')?>' +  ' ' + path : '<?=_('Create the folder at root or select a folder from the tree') ?>'"/>
    </div>
    <div class="bbn-padded">
      <span><?= _("New folder") ?></span>
    </div>
    <div class="bbn-padded">
      <bbn-input bbn-model="text"
                 @keydown.enter.prevent.stop="submit"
      ></bbn-input>
    </div>
    <bbn-input type="hidden" :value="parent"></bbn-input>
  </div>
  <div class="bbn-l bbn-padded">
    <bbn-button text="<?= _("Cancel") ?>"
                icon="nf nf-fa-times"
                @click="closeForm"/>
    <bbn-button text="<?= _("Create folder") ?>"
                icon="nf nf-fa-check"
                @click="submit"/>
  </div>
</bbn-form>