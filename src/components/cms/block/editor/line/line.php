<!-- HTML Document -->

<div class="block-line-edit component-container bbn-padded">
  <div class="bbn-grid-fields">

    <label><?= _("Line width") ?></label>
    <div>
      <bbn-cursor v-model="width"
                  :required="true"
                  :min="0"
                  :max="100"
                  unit="%"/>
    </div>

    <label><?= _("Line size") ?></label>
    <div>
      <bbn-cursor v-model="borderWidth"
                  :required="true"
                  :min="1"
                  :max="10"
                  unit="px"/>
    </div>

    <label><?= _("Line style") ?></label>
    <div>
      <bbn-dropdown v-model="borderStyle"
                    :required="true"
                    :source="borderStyles"/>
    </div>

    <label><?= _("Line color") ?></label>
    <div>
      <bbn-colorpicker v-model="borderColor"/>
    </div>
  </div>
</div>