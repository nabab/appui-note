<!-- HTML Document -->

<div :class="[componentClass, 'bbn-w-100']">
  <div v-if="mode === 'edit'"
       class="bbn-grid-fields bbn-w-100">
    <label v-text="_('Text')"></label>
    <bbn-input  v-model="source.content" />
    <label v-text="_('Link')"></label>
    <bbn-input  v-model="source.url" />
    <label v-text="_('Dimensions')"></label>
    <div>
      <div class="bbn-block bbn-s">
        <bbn-radiobuttons v-model="source.dimensions"
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
      <div class="bbn-block bbn-s">
        <bbn-radiobuttons v-model="source.padding"
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
    <label v-text="_('Class')"/>
    <bbn-input  v-model="source.class"/>
  </div>
  <div v-else-if="!source.content && $parent.selectable"
        class="bbn-alt-background bbn-middle bbn-lpadded"
        style="overflow: hidden">
    <i class="bbn-xxxxl nf nf-md-gesture_tap_button"/>
  </div>
  <div v-else
       class="bbn-w-100" :style="'text-align:'+source.align">
    <bbn-button :url="source.url"
                :text="source.content"
                :class="[source.dimensions, source.padding, source.class]"/>
  </div>
</div>