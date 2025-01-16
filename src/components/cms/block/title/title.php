<!-- HTML Document -->
<div :class="[componentClass, 'bbn-w-100']">
  <div bbn-if="mode === 'edit'">
    <div class="bbn-w-100">
      <bbn-textarea bbn-model="source.content"
                    class="bbn-w-100"/>
    </div>
    <div class="bbn-grid-fields bbn-vpadding bbn-w-100">
      <label><?= _('Tag') ?></label>
      <div>
        <bbn-dropdown :source="tags"
                      bbn-model="source.tag"
                      :component="$options.components.tag"/>
      </div>
      <label><?= _('Color') ?></label>
      <div>
        <bbn-colorpicker bbn-model="source.color"/>
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
      <label><?= _('Style') ?></label>
      <div>
        <bbn-button title="<?= _('Italic') ?>"
                    @click="source.fontStyle = source.fontStyle === 'italic' ? 'normal' : 'italic'"
                    :notext="true"
                    icon="nf nf-fa-italic"
                    :class="{
                      'bbn-state-active': source.fontStyle === 'italic'
                    }"/>
      </div>
      <label><?= _('Decoration') ?></label>
      <div>
        <div class="bbn-block">
          <bbn-radiobuttons :notext="true"
                            bbn-model="source.textDecoration"
                            :source="[{
                              text: _('Underlined'),
                              value: 'underline',
                              icon: 'nf nf-md-format_underline'
                            }, {
                              text: _('Strikethrough'),
                              value: 'line-through',
                              icon: 'nf nf-md-format_strikethrough_variant'
                            }, {
                              text: _('None'),
                              value: 'none',
                              icon: 'nf nf-md-format_title'
                            }]"/>
        </div>
      </div>
      <label><?= _('Horizontal rule') ?></label>
      <div>
        <appui-note-cms-block-line :source="source"
                                   mode="edit"
                                   :details="false"/>
      </div>
    </div>
  </div>
  <div bbn-else
       class="bbn-w-100">
    <appui-note-cms-block-line :source="source"
                               mode="read"
                               :details="false">
      <div bbn-if="$parent.selectable && !source.content"
           class="bbn-alt-background bbn-middle bbn-lpadding"
           style="overflow: hidden">
        <i class="bbn-xxxxl nf nf-md-format_title"/>
      </div>
      <component bbn-else
                 :is="source.tag"
                 :style="currentStyle"
                 bbn-html="source.content"/>
    </appui-note-cms-block-line>
  </div>
</div>
