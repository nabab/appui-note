<!-- HTML Document -->
<div :class="[componentClass, {'bbn-w-100': mode === 'edit'}]">
  <div bbn-if="mode === 'edit'"
       class="bbn-grid-fields bbn-w-100">
    <label bbn-text="_('Video source')"/>
    <bbn-input bbn-model="source.content"/>
    <label><?= _('Width') ?></label>
    <bbn-range bbn-model="source.width"
              :min="10"
              :max="2000"
              :step="10"
              :show-reset="false"
              :show-numeric="true"
              :show-units="true"/>
    <label><?= _('Height') ?></label>
    <bbn-range bbn-model="source.height"
               :disabled="disableHeight"
               :min="10"
               :max="2000"
               :step="10"
               :show-reset="false"
               :show-numeric="true"
               :show-units="true"/>
    <label><?= _('Aspect ratio') ?></label>
    <div>
      <div class="bbn-block">
        <bbn-radiobuttons :source="ratios"
                          bbn-model="source.aspectRatio"/>
      </div>
    </div>
    <label><?= _('Alignment') ?></label>
    <div>
      <div class="bbn-block">
        <bbn-radiobuttons :notext="true"
                          bbn-model="source.align"
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
    <label><?= _('Muted') ?></label>
    <bbn-switch bbn-model="source.muted"
                :title="_('Mute the video')"
                :value="1"
                :novalue="0"
                :no-icon="false"
                on-icon="nf nf-md-volume_mute"
                off-icon="nf nf-md-volume_high"/>
    <label><?= _('Autoplay') ?></label>
    <bbn-switch bbn-model="source.autoplay"
                :title="_('Autoplay')"
                :value="1"
                :novalue="0"
                :no-icon="false"
                on-icon="nf nf-md-play"
                off-icon="nf nf-md-pause"/>
    <label><?= _('Controls') ?></label>
    <bbn-switch bbn-model="source.controls"
                :title="_('Controls')"
                :value="1"
                :novalue="0"
                :no-icon="false"
                on-icon="nf nf-md-play_pause"
                off-icon="nf nf-md-play_pause"/>
    <label><?= _('Loop') ?></label>
    <bbn-switch bbn-model="source.loop"
                :title="_('Loop')"
                :value="1"
                :novalue="0"
                :no-icon="false"
                on-icon="nf nf-md-repeat_variant"
                off-icon="nf nf-md-repeat_variant"/>
  </div>
  <div bbn-else
       class="bbn-flex"
       :style="align">
    <div bbn-if="$parent.selectable && !source.content"
         class="bbn-alt-background bbn-middle bbn-lpadded bbn-w-100"
         style="overflow: hidden">
      <i class="bbn-xxxxl nf nf-md-video_vintage"/>
    </div>
    <div bbn-else-if="!source.content"
         class="bbn-padding bbn-c bbn-lg bbn-w-100"
         bbn-text="_('Missing video content')"/>
    <bbn-video bbn-else
               :width="source.width"
               :height="source.height"
               :aspectRatio="aspectRatio"
               :autoplay="!!source.autoplay"
               :controls="!!source.controls"
               :loop="!!source.loop"
               :muted="!!source.muted"
               :youtube="!!youtube"
               :source="source.content"/>
  </div>
</div>
