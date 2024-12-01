<!-- HTML Document -->

<div class="bbn-w-100 bbn-flex-height">
  <div class="bbn-w-100 bbn-left-padding bbn-top-lpadding bbn-bottom-spadding bbn-grid-full">
    <label class="bbn-w-100"><?= _("URL") ?></label>
    <bbn-input bbn-model="currentData.url"
               class="bbn-lpadding bbn-w-40"></bbn-input>
    <bbn-button class="bbn-w-2"
                @click="openUrl"
                text="Go to"></bbn-button>
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
  <div bbn-if="currentData.cover"
       class="bbn-flex-fill bbn-bottom-spadding bbn-w-100">
    <img :src="currentData.cover"
         style="max-width: 300px; height: 300px; width: auto; height: auto"
         class="bbn-flex-fill bbn-bottom-spadding bbn-w-100">
    <div class="bbn-flex-fill bbn-bottom-spadding bbn-lpadding bbn-w-100">
      <bbn-button bbn-if="currentData.images"
                  @click="showGallery = true"
                  class="bbn-flex-fill bbn-bottom-spadding bbn-spaded bbn-w-20"
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
                     @clickitem="selectImage"
                     :selecting-mode="true"
                     :zoomable="false"
                     :scrollable="true"
                     ></bbn-gallery>
      </bbn-floater>
      <bbn-button	bbn-if="currentData.id_screenshot"
                  @click="showScreenshot"
                  class="bbn-padding"
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
      <div class="bbn-flex-fill bbn-left-padding bbn-bottom-spadding bbn-w-100">
      </div>
    </div>
  </div>
  <div>
    <div class="bbn-w-100 bbn-padding" bbn-if="currentData.id === null">
      <bbn-button class="bbn-padding " text="<?= _('Add Link') ?>" @click="add"></bbn-button>
    </div>
    <div class="bbn-w-100 bbn-lpadding" bbn-else>
      <bbn-button class="bbn-lpadding " text="<?= _('Modify Link') ?>" @click="modify"></bbn-button>
      <bbn-button class="bbn-lpadding"
                  text="<?= _('Delete Link') ?>"
                  @click="deletePreference"></bbn-button>
    </div>
  </div>
</div>