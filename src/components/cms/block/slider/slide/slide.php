<div class="appui-note-cms-block-slider-slide">
  <div class="component-container bbn-block-carousel bbn-w-100" :style="'grid-template-columns:' + columns">
    <div v-for="d in data"
         v-if="data.length"
         :class="['bbn-hspadded', d.class ? d.class +' slider-image-section' : 'slider-image-section']">
      <a :href="d.url ? d.url : ''" class="bbn-100 block-slide-link" v-if="(d.id || d.id_note)">
        <div class="bbn-container-ratio">
          <div class="bbn-100 bbn-flex">
            <img v-if="d.content?.length" :src="d.content" alt="" :style="imgStyle" >
          </div>
          
        </div>
        <div class="bbn-block-gallery-caption bbn-l slider-title"
             :style="'margin-top:' + ( (d.style?.margin && !isMobile) ? d.style.margin : (d.style?.marginMobile && isMobile) ? d.style.marginMobile : '' )"
             v-html="d.title"></div>
        <div v-if="d.desc" class="slider-desc bbn-l" v-html="d.desc"></div>
      </a>
      <div v-else class="empty-col"></div>
  	</div>
  </div>
</div>