<!-- HTML Document -->

<div :class="[componentClass, 'bbn-w-100']">
  <div v-if="mode === 'edit'">
    <div class="bbn-grid-fields bbn-w-100">
      <label v-text="_('Text')"></label>
      <bbn-input  v-model="currentSource.content" />
      <label v-text="_('Link')"></label>
      <bbn-input  v-model="currentSource.url" />
      <label v-text="_('Dimensions')"></label>
      <div>
        <div class="bbn-block bbn-s">
          <bbn-radiobuttons  v-model="currentSource.dimensions"
                            :source="[{
                                text: _('Default'),
                                value: '',
                            },{
                                text: _('XS'),
                                value: 'xs',
                            },{
                                text: _('S'),
                                value: 's',
                            }, {
                                text: _('M'),
                                value: 'm',
                            }, {
                                text: _('L'),
                                value: 'lg',
                            }, {
                                text: _('XL'),
                                value: 'xl',
                            }, {
                                text: _('XXL'),
                                value: 'xxl',
                            }]"/>
        </div>
      </div>
      <label v-text="_('H space')"></label>
      <div>
        <div class="bbn-block bbn-s">
          <bbn-radiobuttons  v-model="currentSource.hpadding"
                            :source="[
                              {
                                text: _('Default'),
                                value: '',
                            }, {
                                text: _('None'),
                                value: 'no',
                            }, {
                                text: _('XS'),
                                value: 'xs',
                            },{
                                text: _('S'),
                                value: 's',
                            }, {
                                text: _('L'),
                                value: 'l',
                            }, {
                                text: _('XL'),
                                value: 'xl',
                            }]"/>
        </div>
      </div>

      <label v-text="_('V space')"></label>
      <div>
        <div class="bbn-block bbn-s">
          <bbn-radiobuttons  v-model="currentSource.vpadding"
                            :source="[
                              {
                                text: _('Default'),
                                value: '',
                            }, {
                                text: _('None'),
                                value: 'no',
                            }, {
                                text: _('XS'),
                                value: 'xs',
                            },{
                                text: _('S'),
                                value: 's',
                            }, {
                                text: _('L'),
                                value: 'l',
                            }, {
                                text: _('XL'),
                                value: 'xl',
                            }]"/>
        </div>
      </div>

      <label v-text="_('Alignment')"></label>
      <div>
        <div class="bbn-block bbn-s">
          <bbn-radiobuttons :notext="true"
                            v-model="currentSource.align"
                            :source="[{
                                text: _('Default'),
                                value: '',
                                icon: 'nf nf-oct-diff_ignored'
                            }, {
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
      <bbn-input  v-model="currentSource.class"/>
    </div>
  </div>
  <div v-else
       class="bbn-w-100" :style="'text-align:'+currentSource.align">
    <bbn-button :url="currentSource.url"
                :text="currentSource.content"
                :class="currentClasses"/>
  </div>
</div>