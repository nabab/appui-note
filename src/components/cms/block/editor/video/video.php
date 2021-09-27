<!-- HTML Document -->

<div class="component-container" id="video-container">
  <div class="bbn-grid-fields bbn-padded">
    <label v-text="_('Video source')"></label>
    <bbn-input v-model="source.content"></bbn-input>
    <label>Muted</label>
    <div>
      <bbn-button :notext="true"
                  :title="_('Mute the video')"
                  @click="muted = !muted"
                  :icon="muted ? 'nf nf-oct-mute' : 'nf nf-oct-unmute'"
                  >
      </bbn-button>
    </div>
    <label>Autoplay</label>
    <div>
      <bbn-button :notext="true"
                  :title="_('Autoplay')"
                  @click="autoplay = !autoplay"
                  :icon="autoplay ? 'nf nf-fa-pause' : 'nf nf-fa-play'"
                  >
      </bbn-button>
    </div>
    <label>Video alignment</label>
    <bbn-block-align-buttons></bbn-block-align-buttons>
    <label>Video width</label>
    <div>
      <bbn-cursor v-model="source.style['width']"
                  :min="100"
                  :max="1000" 
                  :step="10"
                  class="bbn-w-70"
                  ></bbn-cursor>
    </div>
    <label>Video height</label>
    <div>
      <bbn-cursor v-model="source.style['height']"
                  :min="100"
                  :max="1000" 
                  :step="10"
                  class="bbn-w-70"
                  ></bbn-cursor>
    </div>
  </div>
  <div :class="alignClass">
    <bbn-video :width="source.style.width" 
               :style="style" 
               :height="source.style.height"
               :autoplay="autoplay"
               :muted="muted"
               :youtube="youtube"
               :source="source.content"
               ></bbn-video>
  </div>          
</div>
