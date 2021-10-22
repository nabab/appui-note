<!-- HTML Document -->
<div :class="[componentClass, 'bbn-w-100']">
  <div v-if="mode === 'edit'">
    <div class="bbn-w-100">
      <bbn-textarea v-model="source.content"
                    class="bbn-w-100"/>
    </div>
    <div class="bbn-grid-fields bbn-vpadded bbn-w-100">
      <label><?=_('Tag')?></label>
      <div>
        <bbn-dropdown :source="tags"
                      v-model="source.tag"
                      :component="$options.components.tag"/>
      </div>
      <label><?=_('Color')?></label>
      <div>
        <bbn-colorpicker v-model="source.style.color"/>
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
      <label><?=_('Style')?></label>
      <div>
        <bbn-button title="<?=_('Italic')?>"
                    @click="source.style['font-style'] = source.style['font-style'] === 'italic' ? 'normal' : 'italic'"
                    :notext="true"
                    icon="nf nf-fa-italic"
                    :class="['bbn-no-radius', {
                      'bbn-state-active': source.style['font-style'] === 'italic'
                    }]"/>
      </div>
      <label><?=_('Decoration')?></label>
      <div>
        <div class="bbn-block">
          <bbn-radiobuttons :notext="true"
                            v-model="source.style['text-decoration']"
                            :source="[{
                              text: _('Underlined'),
                              value: 'underline',
                              icon: 'nf nf-mdi-format_underline'
                            }, {
                              text: _('Strikethrough'),
                              value: 'line-through',
                              icon: 'nf nf-mdi-format_strikethrough_variant'
                            }, {
                              text: _('None'),
                              value: 'none',
                              icon: 'nf nf-mdi-format_title'
                            }]"/>
        </div>
      </div>
      <label><?=_('Horizontal rule')?></label>
      <div>
        <appui-note-cms-block-line :source="source"
                                   mode="edit"
                                   :details="false"/>
      </div>
      
    </div>
  </div>
  <div v-else
       class="bbn-w-100">
    <appui-note-cms-block-line :source="source"
                               mode="read"
                               :details="false">
      <component :is="source.tag"
                 :style="style"
                 v-html="source.content"/>
    </appui-note-cms-block-line>
  </div>
</div>
