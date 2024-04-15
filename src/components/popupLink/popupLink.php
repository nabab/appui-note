<!-- HTML Document -->

<div class="bbn-w-100 bbn-flex-height">
  <div class="bbn-w-100 bbn-left-padded bbn-top-lpadded bbn-bottom-spadded bbn-grid-full">
    <label class="bbn-w-100"><?= _("URL") ?></label>
    <bbn-input bbn-model="currentData.url"
               class="bbn-lpadded bbn-w-40"></bbn-input>
    <bbn-button class="bbn-w-2"
                @click="openUrl"
                text="Go to"></bbn-button>
  </div>
  <div class="bbn-w-20 bbn-left-padded bbn-bottom-spadded">
    <label class="bbn-w-100"><?= _("In which file ?") ?></label>
    <bbn-dropdown :source="source.parents"
                  bbn-model="idParent"
                  class="bbn-lpadded"
                  placeholder="Is there a parent ?"
                  > </bbn-dropdown>
  </div>
  <div class="bbn-w-50 bbn-left-padded bbn-bottom-spadded">
    <label class="bbn-l bbn-w-100"><?= _("Title") ?></label>
    <bbn-input bbn-model="currentData.title"
               placeholder="Name of the URL"></bbn-input>
  </div>
  <div class="bbn-left-padded bbn-bottom-lpadded bbn-w-100">
    <label class="bbn-l bbn-w-100"><?= _("URL's description") ?></label>
    <bbn-textarea class="bbn-w-40" bbn-model="currentData.description"></bbn-textarea>
  </div>
  <div bbn-if="currentData.cover"
       class="bbn-flex-fill bbn-bottom-spadded bbn-w-100">
    <img :src="currentData.cover"
         style="max-width: 300px; height: 300px; width: auto; height: auto"
         class="bbn-flex-fill bbn-bottom-spadded bbn-w-100">
    <div class="bbn-flex-fill bbn-bottom-spadded bbn-lpadded bbn-w-100">
      <bbn-button bbn-if="currentData.images"
                  @click="showGallery = true"
                  class="bbn-flex-fill bbn-bottom-spadded bbn-spaded bbn-w-20"
                  text="change cover picture"></bbn-button>
      <bbn-floater bbn-if="showGallery"
                   :title="_('Pick a cover picture')"
                   :closable="true"
                   :width="500"
                   :height="500"
                   :scrollable="false"
                   @close="showGallery = false">
        <bbn-gallery :source="currentData.images"
                     class="bbn-overlay"
                     @clickItem="selectImage"
                     :selecting-mode="true"
                     :zoomable="false"
                     :scrollable="true"
                     ></bbn-gallery>
      </bbn-floater>
      <bbn-button	bbn-if="currentData.id_screenshot"
                  @click="showScreenshot"
                  class="bbn-padded"
                  text="show screenshot"
                  ></bbn-button>
      <bbn-floater bbn-if="visible"
                   :closable="true"
                   :width="800"
                   :height="600"
                   :resizable="true"
                   :title="_('a screenshot from the site')"
                   @close="visible = false">
        <img :src="root + 'media/image/' + currentData.id_screenshot">
      </bbn-floater>
      <div class="bbn-flex-fill bbn-left-padded bbn-bottom-spadded bbn-w-100">
      </div>
    </div>
  </div>
  <div>
    <div class="bbn-w-100 bbn-padded" bbn-if="currentData.id === null">
      <bbn-button class="bbn-padded " text="<?= _('Add Link') ?>" @click="add"></bbn-button>
    </div>
    <div class="bbn-w-100 bbn-lpadded" bbn-else>
      <bbn-button class="bbn-lpadded " text="<?= _('Modify Link') ?>" @click="modify"></bbn-button>
      <bbn-button class="bbn-lpadded"
                  text="<?= _('Delete Link') ?>"
                  @click="deletePreference"></bbn-button>
    </div>
  </div>
</div>