<!-- HTML Document -->

<div :class="componentClass">
  <div v-if="mode === 'edit'"
       :class="['component-container', 'bbn-c']"
       :style="style">
    <!-- GIVE HREF TO VIEW FULL IMAGE -->
    <appui-note-cms-block-gallery-item v-if="source.source[currentPage]"
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
  <div :class="['bbn-block-gallery', alignClass, columnsClass]"
       :style="style"
       v-else>
    <appui-note-cms-block-gallery-item v-for="(image, idx) in source.source"
                                              :source="image"
                                              :key="idx"
                                              :index="idx"/>
  </div>
</div>
