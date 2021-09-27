<!-- HTML Document -->

<div class="component-container bbn-block-image" :class="alignClass">
  <div class="bbn-padded">
    <div class="bbn-grid-fields bbn-vspadded">
      <label v-text="_('Upload your image')"></label>
      <bbn-upload :save-url="'upload/save/' + ref"
                  remove-url="test/remove"
                  :json="true"
                  :paste="true"
                  :multiple="false"	
                  v-model="image"
                  @success="imageSuccess"
                  ></bbn-upload>

      <label v-text="_('Image size')"></label>
      <bbn-cursor v-model="source.style['width']" 
                  unit="%"
                  :min="0"
                  :max="100"
                  :step="20"
                  ></bbn-cursor>

      <label v-text="_('Image alignment')"></label>
      <bbn-block-align-buttons></bbn-block-align-buttons>
    </div> 
  </div>
  <img :src="$parent.path + source.src" :style="style">
  <p class="image-caption bbn-l bbn-s bbn-vsmargin" v-if="source.caption" v-html="source.caption"></p>
</div>          
