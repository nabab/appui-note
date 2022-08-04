<!-- HTML Document -->
<div :class="componentClass">
  <div v-if="mode === 'edit'"
       class="bbn-grid-fields bbn-vspadded bbn-w-100">
    <label v-text="_('Video source')"/>
    <bbn-input v-model="source.source"/>
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
    <label><?=_('Alignment')?></label>
    <div>
      <div class="bbn-block">
        <bbn-radiobuttons :notext="true"
                          v-model="source.align"
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
    <bbn-range v-model="source.style.width"
									 :min="10"
									 :max="2000" 
									 :step="10"
									 :show-reset="false"
									 :show-numeric="true"
									 :show-units="true"/>
    <label><?=_('Height')?></label>
    <bbn-range v-model="source.style.height"
									 :min="10"
									 :max="2000" 
									 :step="10"
									 :show-reset="false"
									 :show-numeric="true"
									 :show-units="true"/>
  </div>
  <div v-else
       class="bbn-flex"
       :style="align">
    <bbn-video :style="{
                  height: source.style.height,
                  width: width
                }" 
               :autoplay="!!source.autoplay"
               :controls="!!source.controls"
               :loop="!!source.loop"
               :muted="!!source.muted"
               :youtube="!!youtube"
               :source="source.source"/>
  </div>     
</div>
