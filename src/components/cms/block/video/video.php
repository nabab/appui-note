<!-- HTML Document -->
<div :class="componentClass">
  <div v-if="mode === 'edit'"
       class="bbn-grid-fields bbn-w-100">
    <label v-text="_('Video source')"/>
    <bbn-input v-model="currentSource.content"/>
    <label><?=_('Muted')?></label>
    <div>
      <bbn-button :notext="true"
                  :title="_('Mute the video')"
                  @click="currentSource.muted = !!currentSource.muted ? 0 : 1"
                  :icon="currentSource.muted ? 'nf nf-oct-mute' : 'nf nf-oct-unmute'"
                  :class="['bbn-white', {
                      'bbn-bg-green': !!currentSource.muted,
                      'bbn-bg-red': !currentSource.muted
                    }]"/>
    </div>
    <label><?=_('Autoplay')?></label>
    <div>
      <bbn-button :notext="true"
                  :title="_('Autoplay')"
                  @click="currentSource.autoplay = !!currentSource.autoplay ? 0 : 1"
                  :icon="currentSource.autoplay ? 'nf nf-fa-pause' : 'nf nf-fa-play'"
                  :class="['bbn-white', {
                      'bbn-bg-green': !!currentSource.autoplay,
                      'bbn-bg-red': !currentSource.autoplay
                    }]"/>
    </div>
    <label><?=_('Controls')?></label>
    <div>
      <bbn-button :notext="true"
                  :title="_('Controls')"
                  @click="currentSource.controls = !!currentSource.controls ? 0 : 1"
                  icon="nf nf-mdi-play_pause"
                  :class="['bbn-white', {
                    'bbn-bg-green': !!currentSource.controls,
                    'bbn-bg-red': !currentSource.controls
                  }]"/>
    </div>
    <label><?=_('Loop')?></label>
    <div>
      <bbn-button :notext="true"
                  :title="_('Loop')"
                  @click="currentSource.loop = !!currentSource.loop ? 0 : 1"
                  icon="nf nf-mdi-loop"
                  :class="['bbn-white', {
                    'bbn-bg-green': !!currentSource.loop,
                    'bbn-bg-red': !currentSource.loop
                  }]"/>
    </div>
    <label><?=_('Alignment')?></label>
    <div>
      <div class="bbn-block">
        <bbn-radiobuttons :notext="true"
                          v-model="currentSource.align"
                          :source="[{
                            text: _('Align left'),
                            value: 'left',
                            icon: 'nf nf-fa-align_left'
                          }, {
                            text: _('Align center'),
                            value: 'center',
                            icon: 'nf nf-fa-align_center'
                          }, {
                            text: _('Align right'),
                            value: 'right',
                            icon: 'nf nf-fa-align_right'
                          }]"/>
      </div>
    </div>
    <label><?=_('Width')?></label>
    <bbn-range v-model="currentSource.width"
              :min="10"
              :max="2000" 
              :step="10"
              :show-reset="false"
              :show-numeric="true"
              :show-units="true"/>
    <label><?=_('Height')?></label>
    <bbn-range v-model="currentSource.height"
               :disabled="disableHeight"
               :min="10"
               :max="2000" 
               :step="10"
               :show-reset="false"
               :show-numeric="true"
               :show-units="true"/>
      

    <label><?=_('Aspect ratio')?></label>      
    <bbn-dropdown :source="ratios"
                  :nullable="true"
                  v-model="currentSource.aspectRatio"
    />      
  </div>
  <div v-else
       class="bbn-flex"
       :style="align">
    <div class="bbn-padding bbn-c bbn-lg bbn-w-100"
         v-text="_('Missing video content')"
         v-if="!currentSource.content"/>
    <bbn-video v-else
               :width="currentSource.width"
               :height="currentSource.height"
               :aspectRatio="aspectRatio"
               :autoplay="!!currentSource.autoplay"
               :controls="!!currentSource.controls"
               :loop="!!currentSource.loop"
               :muted="!!currentSource.muted"
               :youtube="!!youtube"
               :source="currentSource.content"/>
  </div>     
</div>
