<!-- HTML Document -->

<form>
  <div class="bbn-w-100 bbn-flex-height">
    <div class="bbn-w-100 bbn-left-padding bbn-top-lpadding bbn-bottom-spadding bbn-grid-full">
      <label class="bbn-w-100"><?= _("URL") ?></label>
      <bbn-input bbn-model="currentData.url"
                 class="bbn-lpadding bbn-w-40"></bbn-input>
      <bbn-button class="bbn-w-2"
                  @click="openUrl"
                  label="Go to"></bbn-button>
    </div>
    <div class="bbn-w-20 bbn-left-padding bbn-bottom-spadding">
      <label class="bbn-w-100"><?= _("In which file ?") ?></label>
      <bbn-dropdown :source="source.parents"
                    bbn-model="idParent"
                    class="bbn-lpadding"
                    placeholder="Is there a parent ?"
                    > </bbn-dropdown>
    </div>
    <div class="bbn-w-50 bbn-left-padding bbn-bottom-spadding">
      <label class="bbn-l bbn-w-100"><?= _("Title") ?></label>
      <bbn-input bbn-model="currentData.title"
                 placeholder="Name of the URL"></bbn-input>
    </div>
    <div class="bbn-left-padding bbn-bottom-lpadding bbn-w-100">
      <label class="bbn-l bbn-w-100"><?= _("URL's description") ?></label>
      <bbn-textarea class="bbn-w-40" bbn-model="currentData.description"></bbn-textarea>
    </div>
    <div>
      <div class="bbn-w-100 bbn-padding" bbn-if="currentData.id === null">
        <bbn-button class="bbn-padding " label="<?= _('Add Link') ?>" @click="add"></bbn-button>
      </div>
      <div class="bbn-w-100 bbn-lpadding" bbn-else>
        <bbn-button class="bbn-lpadding " label="<?= _('Modify Link') ?>" @click="modify"></bbn-button>
        <bbn-button class="bbn-lpadding"
                    label="<?= _('Delete Link') ?>"
                    @click="deletePreference"></bbn-button>
      </div>
    </div>
  </div>
</form>