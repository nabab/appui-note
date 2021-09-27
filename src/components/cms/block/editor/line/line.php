<!-- HTML Document -->

<div class="block-line-edit component-container">
  <hr :style="style">
  <div class="block-line-edit-command bbn-padded">
    <div class="bbn-grid-fields bbn-vspadded">

      <label><?= _("Line width") ?></label>
      <div>
        <bbn-cursor v-model="data.width"
                    :min="0"
                    :max="100" 
                    unit="%"/>
      </div>

      <label><?= _("Line size") ?></label>
      <div>
        <bbn-cursor v-model="data.borderWidth"
                    :min="1"
                    :max="10" 
                    unit="px"/>
      </div>

      <label><?= _("Line style") ?></label>
      <div>
        <bbn-dropdown v-model="data.borderStyle"
                      :source="borderStyle"/>
      </div>

      <label><?= _("Line color") ?></label>
      <div>
        <bbn-colorpicker v-model="data.borderColor"/>
      </div>

      <label><?= _("Line alignment") ?></label>
      <appui-note-cms-block-align/>
    </div>
  </div>
</div>