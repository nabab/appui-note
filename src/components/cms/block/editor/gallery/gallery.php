<!-- HTML Document -->

<div :class="componentClass">
  <div v-if="show"
       :class="['component-container', 'bbn-block-gallery', alignClass, columnsClass]"
       :style="style">
    <!-- GIVE HREF TO VIEW FULL IMAGE -->
    <bbn-cms-block-gallery-item v-for="(image, idx) in source.content"
                                :source="image"
                                :key="idx"
                                :index="idx"/>
  </div>
  <div class="bbn-grid-fields bbn-padded">
    <label>Columns number</label>
    <div>
      <bbn-dropdown v-model="source.columns"
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
