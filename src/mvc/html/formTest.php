<!-- HTML Document -->

<form>
  <div class="bbn-w-100 bbn-flex-height">
    <div class="bbn-w-100 bbn-left-padded bbn-top-lpadded bbn-bottom-spadded bbn-grid-full">
      <label class="bbn-w-100"><?=_("URL")?></label>
      <bbn-input v-model="currentData.url"
                 class="bbn-lpadded bbn-w-40"></bbn-input>
      <bbn-button class="bbn-w-2"
                  @click="openUrl"
                  text="Go to"></bbn-button>
    </div>
    <div class="bbn-w-20 bbn-left-padded bbn-bottom-spadded">
      <label class="bbn-w-100"><?=_("In which file ?")?></label>
      <bbn-dropdown :source="source.parents"
                    v-model="idParent"
                    class="bbn-lpadded"
                    placeholder="Is there a parent ?"
                    > </bbn-dropdown>
    </div>
    <div class="bbn-w-50 bbn-left-padded bbn-bottom-spadded">
      <label class="bbn-l bbn-w-100"><?=_("Title")?></label>
      <bbn-input v-model="currentData.title"
                 placeholder="Name of the URL"></bbn-input>
    </div>
    <div class="bbn-left-padded bbn-bottom-lpadded bbn-w-100">
      <label class="bbn-l bbn-w-100"><?=_("URL's description")?></label>
      <bbn-textarea class="bbn-w-40" v-model="currentData.description"></bbn-textarea>
    </div>
    <div>
      <div class="bbn-w-100 bbn-padded" v-if="currentData.id === null">
        <bbn-button class="bbn-padded " text="<?= _('Add Link') ?>" @click="add"></bbn-button>
      </div>
      <div class="bbn-w-100 bbn-lpadded" v-else>
        <bbn-button class="bbn-lpadded " text="<?= _('Modify Link') ?>" @click="modify"></bbn-button>
        <bbn-button class="bbn-lpadded"
                    text="<?= _('Delete Link') ?>"
                    @click="deletePreference"></bbn-button>
      </div>
    </div>
  </div>
</form>