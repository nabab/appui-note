<!-- HTML Document -->
<div :class="[componentClass]">
  <div v-if="mode === 'edit'"
       class="bbn-grid-fields bbn-w-100">
    <!--label><?= _('Color') ?></!--label>
    <div>
      <bbn-colorpicker v-model="color"/>
    </div>

    <label><?= _('Alignment') ?></label>
    <div>
      <div class="bbn-block">
        <bbn-radiobuttons :notext="true"
                          v-model="align"
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
    </div -->
    <div class="bbn-grid-full">
      <bbn-textarea v-model="source.content"
                    style="min-height: 20vh; height: 20em; width: 100%"/>
    </div>
  </div>
  <div v-else-if="currentContent"
       v-html="currentContent"
       class="bbn-rel"
       :style="{
         color: source.color ? source.color : undefined,
         textAlign: source.align ? source.align : undefined
       }"/>
  <div v-else-if="$parent.selectable"
       class="bbn-rel bbn-alt-background bbn-middle bbn-lpadded"
       style="overflow: hidden;">
    <i class="bbn-xxxxl nf nf-md-text_box"/>
  </div>
</div>
