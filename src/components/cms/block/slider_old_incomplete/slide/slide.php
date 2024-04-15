<div class="block-slide">
  <div class="component-container bbn-block-carousel bbn-w-100">
    <div bbn-for="d in data"
         bbn-bind:class = "d.class ? d.class+' slider-image-section' : 'slider-image-section'">
    	<a :href="d.url ? d.url : ''">
        <img :src="d.front_img ? d.front_img.path : '' " alt="">
        <div class="bbn-block-gallery-caption bbn-l slider-title"
             bbn-html="d.title"></div>
        <div bbn-if="d.desc" class="slider-desc bbn-l" bbn-html="d.desc"></div>
       </a>
  	</div>
  </div>
</div>