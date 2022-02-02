<!-- HTML Document -->

<bbn-form :action="formAction"
          :source="currentData"
          v-model="currentData">
  <div class="bbn-padded bbn-grid-fields" :required="true">
    <label><?=_("URL")?></label>
    <div>
      <bbn-input v-model="currentData.url"></bbn-input>
      <bbn-button class="bbn-w-2"
                  @click="openUrl"
                  text="Go to"></bbn-button>
    </div>

<!--     <label><?=_("In which file ?")?></label>
   <bbn-dropdown  :source="parents"
                  v-model="idParent"
                  placeholder="Is there a parent ?"
                  ></bbn-dropdown>-->

    <label><?=_("Title")?></label>
    <bbn-input v-model="currentData.title"
               placeholder="Name of the URL"></bbn-input>

    <label><?=_("URL's description")?></label>
    <bbn-textarea v-model="currentData.description"></bbn-textarea>
    </div>
    <div v-if="currentData.cover"
         class="bbn-grid-fields">
      <img :src="currentData.cover"
           style="max-width: 200px; height: 200px; width: auto; height: auto">
      <bbn-button v-if="source.images"
                  @click="showGallery = true"
                  class="bbn-w-20"
                  text="change cover picture"></bbn-button>
      <bbn-floater v-if="showGallery"
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
      <bbn-button	v-if="currentData.id_screenshot"
                  @click="showScreenshot"
                  class="bbn-padded"
                  text="show screenshot"
                  ></bbn-button>
      <bbn-floater v-if="visible"
                   :closable="true"
                   :width="800"
                   :height="600"
                   :resizable="true"
                   :title="_('a screenshot from the site')"
                   @close="visible = false">
        <img :src="root + 'media/image/' + currentData.id_screenshot">
      </bbn-floater>
    </div>
</bbn-form>