<!-- HTML Document -->


<!--IMPORTANT CHANGE FROM CLICK TO HREF WHEN WILL BE POSSIBLE TO MAKE LINK-->
<!--a  target="_self" :href="(source.href ? (linkURL + source.href) : source.src)"-->
<a target="_self" @click="selectImg">
  <!--TO TAKE IMAGE FROM THE INDEX-->
  <img :src="path + source.src" :alt="source.alt ? source.alt : ''"
       :style="$parent.style">
  <div v-if="source.caption || (source.title && (type === 'carousel'))" 
       :class="['bbn-block-gallery-caption',$parent.alignClass]"
       v-html="(source.caption && (type === 'gallery')) ? source.caption : source.title"
       ></div>
  <div v-if="source.details_title" 
       :class="['image-details-title',$parent.alignClass]"
       v-html="source.details_title"
       ></div>
  <div v-if="source.details" 
       :class="['image-details',$parent.alignClass]"
       v-html="source.details"
       ></div>
  <div v-if="source.price" 
       :class="['image-price',$parent.alignClass]"
       v-text="source.price"
       ></div>
  <time v-if="source.time" v-text="source.time" :class="$parent.alignClass"></time>
</a>
