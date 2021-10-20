<!-- HTML Document -->
<div :class="componentClass">
  <div v-if="mode === 'edit'"
       class="bbn-grid-fields bbn-vspadded bbn-w-100">
    <label v-text="_('Video source')"/>
    <bbn-input v-model="source.src"/>
    <label><?=_('Muted')?></label>
    <div>
      <bbn-button :notext="true"
                  :title="_('Mute the video')"
                  @click="source.muted = !!source.muted ? 0 : 1"
                  :icon="source.muted ? 'nf nf-oct-mute' : 'nf nf-oct-unmute'"
                  :class="['bbn-white', {
                      'bbn-bg-green': !!source.muted,
                      'bbn-bg-red': !source.muted
                    }]"/>
    </div>
    <label><?=_('Autoplay')?></label>
    <div>
      <bbn-button :notext="true"
                  :title="_('Autoplay')"
                  @click="source.autoplay = !!source.autoplay ? 0 : 1"
                  :icon="source.autoplay ? 'nf nf-fa-pause' : 'nf nf-fa-play'"
                  :class="['bbn-white', {
                      'bbn-bg-green': !!source.autoplay,
                      'bbn-bg-red': !source.autoplay
                    }]"/>
    </div>
    <template v-if="youtube">
      <label><?=_('Controls')?></label>
      <div>
        <bbn-button :notext="true"
                    :title="_('Controls')"
                    @click="source.controls = !!source.controls ? 0 : 1"
                    icon="nf nf-mdi-play_pause"
                    :class="['bbn-white', {
                      'bbn-bg-green': !!source.controls,
                      'bbn-bg-red': !source.controls
                    }]"/>
      </div>
      <label><?=_('Loop')?></label>
      <div>
        <bbn-button :notext="true"
                    :title="_('Loop')"
                    @click="source.loop = !!source.loop ? 0 : 1"
                    icon="nf nf-mdi-loop"
                    :class="['bbn-white', {
                      'bbn-bg-green': !!source.loop,
                      'bbn-bg-red': !source.loop
                    }]"/>
      </div>
    </template>
    <label><?=_('Video alignment')?></label>
    <div>
      <bbn-block-align-buttons/>
    </div>
    <label><?=_('Video width')?></label>
    <div class="bbn-flex-width bbn-vmiddle">
      <bbn-cursor v-model="currentWidth"
                  :min="10"
                  :max="2000" 
                  :step="10"
                  class="bbn-flex-fill bbn-right-sspace"
                  :unit="currentWidthUnit"/>
      <bbn-dropdown v-model="currentWidthUnit"
                    :source="units"
                    style="width: 6em"/>
    </div>
    <label><?=_('Video height')?></label>
    <div class="bbn-flex-width bbn-vmiddle">
      <bbn-cursor v-model="currentHeight"
                  :min="10"
                  :max="2000" 
                  :step="10"
                  class="bbn-flex-fill bbn-right-sspace"
                  :unit="currentHeightUnit"/>
      <bbn-dropdown v-model="currentHeightUnit"
                    :source="units"
                    style="width: 6em"/>
    </div>
  </div>
  <div v-else>
    <bbn-video :width="source.style.width" 
               :style="style" 
               :height="source.style.height"
               :autoplay="!!source.autoplay"
               :controls="!!source.controls"
               :loop="!!source.loop"
               :muted="!!source.muted"
               :youtube="!!youtube"
               :source="source.src"/>
  </div>     
</div>
