<div class="appui-note-cms-block-slider-slide">
  <div class="component-container bbn-block-carousel bbn-w-100" :style="'grid-template-columns:' + columns">
    <div bbn-for="d in data"
         bbn-if="data.length"
         :class="['bbn-hspadding', d.class ? d.class +' slider-image-section' : 'slider-image-section']">
      <a :href="d.url ? d.url : ''" class="bbn-100 block-slide-link" bbn-if="(d.id || d.id_note)">
        <div class="bbn-container-ratio">
          <div class="bbn-100 bbn-flex">
            <img bbn-if="d.content?.length" :src="d.content" alt="" :style="imgStyle" >
          </div>
        </div>
        <div class="bbn-block-gallery-caption bbn-l slider-title"
             :style="'margin-top:' + ( (d.style?.margin && !isMobile) ? d.style.margin : (d.style?.marginMobile && isMobile) ? d.style.marginMobile : '' )"
             bbn-html="d.title"></div>
        <div bbn-if="d.desc" class="slider-desc bbn-l" bbn-html="d.desc"></div>
      </a>
      <div bbn-else class="empty-col"></div>
  	</div>
  </div>
</div>