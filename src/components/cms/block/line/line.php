<!-- HTML Document -->

<div :class="[componentClass, 'bbn-w-100']">
  <div v-if="mode === 'edit'">
    <div class="bbn-button-group">
      <bbn-button :text="_('TOP')" 
                  @click="line = 'top'" 
                  :class="{'bbn-state-active': line === 'top'}"/>
      <bbn-button	:text="_('BOTTOM')"
                  @click="line = 'bottom'"
                  :class="{'bbn-state-active': line === 'bottom'}"/>
      <bbn-button :text="_('BOTH')"
                  @click="line = 'both'"
                  :class="{'bbn-state-active': line === 'both'}"/>
      <bbn-button :text="_('NONE')"
                  @click="line = null"
                  :class="{'bbn-state-active': !line}"/>
    </div>
    <div v-if="details"
         class="bbn-grid-fields bbn-vpadded bbn-w-100">
      <label v-text="_('Width')"></label>
      <bbn-range v-model="source.style.width"
                  :min="10"
                  :max="2000" 
                  :step="10"
                  :show-reset="false"
                  :show-label="true"
                  :show-units="true"/>
      <label><?=_('Height')?></label>
      <bbn-range v-model="source.style.height"
                  :min="10"
                  :max="2000" 
                  :step="10"
                  :show-reset="false"
                  :show-label="true"
                  :show-units="true"/>
      <label v-text="_('Alignment')"></label>
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
    </div>
  </div>
  <div v-else
       class="bbn-w-100">
    <hr v-if="['both', 'top', true].includes(line)"
      :style="style">
    <slot></slot>
    <hr v-if="['both', 'bottom', true].includes(line)"
        :style="style">
  </div>
</div>