<!-- HTML Document -->

<bbn-form :action="formAction"
          :source="currentData"
          bbn-model="currentData"
          class="bbn-m">
  <div class="bbn-padding bbn-grid-fields" >
    <label><?= _("URL") ?></label>
    <div class="bbn-flex-width">
      <bbn-input bbn-model="currentData.url"
                 class="bbn-flex-fill bbn-right-space"></bbn-input>
      <bbn-button class="bbn-w-2"
                  @click="openUrl"
                  label="Go to"></bbn-button>
    </div>

    <label><?= _("In which file ?") ?></label>
    <bbn-dropdown :source="bookmarkCp.parents"
                  class="bbn-wider"
                  bbn-model="idParent"
                  placeholder="Is there a parent ?"
                  ></bbn-dropdown>

    <label><?= _("Title") ?></label>
    <bbn-input bbn-model="currentData.title"
               :required="true"
               placeholder="Name of the URL"></bbn-input>

    <label><?= _("URL's description") ?></label>
    <bbn-textarea bbn-model="currentData.description"></bbn-textarea>

    <div bbn-if="currentData.cover">
      <img :src="currentData.cover"
           style="max-width: 200px; max-height: 200px; width: auto; height: auto">
    </div>
    <div bbn-if="currentData.cover">
      <bbn-button bbn-if="currentData.images"
                  @click="showGallery = true"
                  label="change cover picture"></bbn-button>
    </div>
    <div>
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
    </div>

		<div>
      <bbn-button	bbn-if="currentData.id_screenshot"
                @click="showScreenshot"
                class="bbn-padding"
                label="show screenshot"
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
    </div>
  </div>
</bbn-form>