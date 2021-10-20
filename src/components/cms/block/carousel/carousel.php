<!-- HTML Document -->
<div :class="componentClass">
  <div v-if="mode === 'edit'">edit</div>
  <div v-else
       :class="['component-container', 'bbn-block-carousel', 'bbn-w-100',  alignClass]"
       :style="style"
       v-if="show">
    <div v-for="(group, idx) in items"
         v-if="idx === currentCarouselIdx">
      <bbn-cms-carousel-control :source="idx"
                                :key="idx"
                                v-if="carouselSource.length > 3"/>
      <div :class="['bbn-w-100', columnsClass]">
        <bbn-cms-block-gallery-item v-for="(image, imgIdx) in group"
                                    :source="image"
                                    :key="imgIdx"
                                    :index="imgIdx"/>
      </div>
    </div>
  </div>
</div>