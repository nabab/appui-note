<!-- HTML Document -->

<div :class="componentClass">
  <div v-if="mode === 'edit'"
       :class="['component-container', 'bbn-block-image', alignClass]">
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
  <div class="component-container bbn-block-image"
       :class="alignClass">
    <a v-if="source.href"
       target="_self"
       :href="$parent.linkURL + source.href"
       class="bbn-c">
      <img :src="$parent.path + source.src"
           style="height:500px; width:100%"
           :style="style"
           :alt="source.alt ? source.alt : ''"
           >
    </a>
    <img v-else
         :src="$parent.path + source.src"
         :style="style"
         :alt="source.alt ? source.alt : ''"
         >
    <p class="image-caption bbn-l bbn-s bbn-vsmargin"
       v-if="source.caption"
       v-html="source.caption"
       ></p>
    <!--error when using decodeuricomponent on details of home image-->
    <a class="image-details-title bbn-l bbn-vsmargin bbn-w-100"
       v-if="source.details_title"
       v-html="(source.details_title)"
       :href="source.href"
       target="_blank"
       ></a>
    <p class="image-details bbn-l bbn-vsmargin"
       v-if="source.details"
       v-html="(source.details)"
       ></p>
  </div>
</div>
