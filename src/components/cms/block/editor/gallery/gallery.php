<!-- HTML Document -->

<div :class="componentClass">
  <div v-if="show"
       :class="['component-container', 'bbn-c']"
       :style="style">
    <!-- GIVE HREF TO VIEW FULL IMAGE -->
    <appui-note-cms-block-reader-gallery-item v-if="source.source[currentPage]"
                                              :source="source.source[currentPage]"
                                              :index="currentPage"/>
    <bbn-pager :element="cp"
               :extra-controls="false"
               pageName="<?= _("image") ?>"/>
  </div>
  <div class="bbn-grid-fields bbn-padded">
    <label>Columns number</label>
    <div>
      <bbn-dropdown v-model="formData.columns"
                    :source="tinyNumbers"/>
    </div>
    <label v-text="_('Upload your images')"/>
    <bbn-upload :save-url="'upload/save/' + ref"
                remove-url="test/remove"
                :data="{gallery: true}"
               :paste="true"
                :multiple="true"
                v-model="source.content"
                @success="imageSuccess"/>
  </div>
</div>
