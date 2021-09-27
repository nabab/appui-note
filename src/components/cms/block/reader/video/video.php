<!-- HTML Document -->

<div :class="['component-container', 'bbn-cms-block-video', alignClass]">
  <!--ERROR ON HOME-->
  <!--bbn-video :width="source.width" 
                     :style="style" 
                     :height="source.height"
                     :autoplay="autoplay"
                     :muted="muted"
                     :youtube="youtube"
                     :source="source.src"
          ></bbn-video-->
  <iframe 
          :style="style" 

          :autoplay="false"

          :src="source.src"
          ></iframe>       
</div>