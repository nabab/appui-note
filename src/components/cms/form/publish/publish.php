<!-- HTML Document -->
<bbn-form :action="url"
          :source="formData"
          ref="form"
          :prefilled="true"
          @success="success"
          class="<?= $componentName ?>">
  <div class="bbn-grid-fields bbn-lpadded">
    <div class="bbn-grid-full bbn-s bbn-c bbn-nowrap bbn-bottom-spadded">
      <?= _("You can program the publication for now or the future") ?>
    </div>

    <label class="bbn-label"><?= _("Publication date") ?></label>
    <bbn-datetimepicker bbn-model="formData.start"
                        :min="now"
                        :max="maxStart"
                        :required="true"/>

    <div class="bbn-grid-full bbn-s bbn-c bbn-nowrap bbn-vpadded">
      <?= _("You can (or not) end a publication") ?>
    </div>

    <label class="bbn-label"><?= _("End of publication") ?></label>
    <bbn-datetimepicker bbn-model="formData.end"
                        :disabled="!formData.start"
                        :min="minEnd"/>
  </div>
</bbn-form>
