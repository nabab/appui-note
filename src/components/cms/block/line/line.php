<!-- HTML Document -->

<div :class="[componentClass, 'bbn-w-100']">
  <div bbn-if="mode === 'edit'"
        class="bbn-grid-fields bbn-w-100">
    <bbn-radiobuttons class="bbn-grid-full"
                      bbn-model="source.hr"
                      :source="[{
                        text: _('Top'),
                        value: 'top'
                      }, {
                        text: _('Bottom'),
                        value: 'bottom'
                      }, {
                        text: _('Both'),
                        value: 'both'
                      }, {
                        text: _('None'),
                        value: null
                      }]"/>
    <template bbn-if="details">
      <label bbn-text="_('Width')"></label>
      <bbn-range bbn-model="source.width"
                  :min="10"
                  :max="2000"
                  :step="10"
                  :show-reset="false"
                  :show-numeric="true"
                  :show-units="true"/>
      <label><?= _('Height') ?></label>
      <bbn-range bbn-model="source.height"
                  :min="10"
                  :max="2000"
                  :step="10"
                  :show-reset="false"
                  :show-numeric="true"
                  :show-units="true"/>
      <label bbn-text="_('Alignment')"></label>
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
    </template>
  </div>
  <div bbn-else
       class="bbn-w-100">
    <hr bbn-if="['both', 'top', true].includes(line)"
      :style="style">
    <slot></slot>
    <hr bbn-if="['both', 'bottom', true].includes(line)"
        :style="style">
    <div bbn-if="!line && $parent.selectable"
         class="bbn-alt-background bbn-middle bbn-lpadding bbn-w-100"
         style="overflow: hidden">
      <i class="bbn-xxxxl nf nf-cod-horizontal_rule"/>
    </div>
  </div>
</div>
