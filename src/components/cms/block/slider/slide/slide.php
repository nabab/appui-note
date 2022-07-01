<div class="block-slide">
  <div class="component-container bbn-block-carousel bbn-w-100" :style="'grid-template-columns:' + columns">
    <div v-for="d in data"
         v-if="data.length"
         class="bbn-hspadded"
         :style="d.style"
         v-bind:class = "d.class ? d.class+' slider-image-section' : 'slider-image-section'">
      <a :href="d.url ? d.url : ''" class="bbn-100 block-slide-link">
        <img v-if="d.front_img || d.path" :src="d.front_img ? d.front_img.path : d.path" alt="">
        <div class="bbn-block-gallery-caption bbn-l slider-title bbn-top-padded"
             v-html="d.title"></div>
             
        <div v-if="d.desc" class="slider-desc bbn-l" v-html="d.desc"></div>
       </a>
  	</div>
  </div>
</div>