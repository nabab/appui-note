<!-- HTML Document -->

<div class="component-container bbn-block-image" :class="alignClass">
  <a v-if="source.href" target="_self" :href="$parent.linkURL + source.href" class="bbn-c">
    <img :src="$parent.path + source.src"
         style="heigth:500px;width:100%"
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