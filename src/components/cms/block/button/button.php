<!-- HTML Document -->

<div :class="[componentClass, 'bbn-w-100']">
  <div v-if="mode === 'edit'">
    <div class="bbn-grid-fields bbn-vpadded bbn-w-100">
     
      <label v-text="_('Text')"></label>
      <bbn-input  v-model="source.text" />
    
      <label v-text="_('Link')"></label>
      <bbn-input  v-model="source.url" />

      <label v-text="_('Dimensions')"></label>
      <div>
        <div class="bbn-block">
          <bbn-radiobuttons  v-model="source.dimensions"
                            :source="[{
                                text: _('Default'),
                                value: '',
                            },{
                                text: _('XS'),
                                value: 'bbn-xs',
                            },{
                                text: _('S'),
                                value: 'bbn-s',
                            }, {
                                text: _('M'),
                                value: 'bbn-m',
                            }, {
                                text: _('L'),
                                value: 'bbn-large',
                            }, {
                                text: _('XL'),
                                value: 'bbn-xlarge',
                            }, {
                                text: _('XXL'),
                                value: 'bbn-xxlarge',
                            }]"/>
        </div>
      </div>

      <label v-text="_('Space')"></label>
      <div>
        <div class="bbn-block">
          <bbn-radiobuttons  v-model="source.padding"
                            :source="[
                              {
                                text: _('No space'),
                                value: 'bbn-no-padding',
                            }, {
                                text: _('XS'),
                                value: 'bbn-xspadded',
                            },{
                                text: _('S'),
                                value: 'bbn-spadded',
                            }, {
                                text: _('L'),
                                value: 'bbn-lpadded',
                            }, {
                                text: _('XL'),
                                value: 'bbn-xlpadded',
                            }]"/>
        </div>
      </div>


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
       class="bbn-w-100" :style="'text-align:'+source.align">
    <bbn-button :url="source.url" :text="source.text" :class="[source.dimensions,source.padding]"></bbn-button>
  </div>
</div>