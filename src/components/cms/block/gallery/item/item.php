<!-- HTML Document -->


<!--IMPORTANT CHANGE FROM CLICK TO HREF WHEN WILL BE POSSIBLE TO MAKE LINK-->
<!--a  target="_self" :href="(source.href ? (linkURL + source.href) : source.src)"-->
<a target="_self" @click="selectImg">
  <!--TO TAKE IMAGE FROM THE INDEX-->
  <img :src="path + source.src" :alt="source.alt ? source.alt : ''"
       :style="$parent.style">
  <div bbn-if="source.caption || (source.title && (type === 'carousel'))" 
       :class="['bbn-block-gallery-caption',$parent.alignClass]"
       bbn-html="(source.caption && (type === 'gallery')) ? source.caption : source.title"
       ></div>
  <div bbn-if="source.details_title" 
       :class="['image-details-title',$parent.alignClass]"
       bbn-html="source.details_title"
       ></div>
  <div bbn-if="source.details" 
       :class="['image-details',$parent.alignClass]"
       bbn-html="source.details"
       ></div>
  <div bbn-if="source.price" 
       :class="['image-price',$parent.alignClass]"
       bbn-text="source.price"
       ></div>
  <time bbn-if="source.time" bbn-text="source.time" :class="$parent.alignClass"></time>
</a>
