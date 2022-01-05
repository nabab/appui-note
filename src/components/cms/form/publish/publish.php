<!-- HTML Document -->

<div class="bbn-overlay <?= $componentName ?> bbn-middle">
  <div class="bbn-block bbn-lpadded bbn-lg bbn-bg-black bbn-white">
    <bbn-form :action="url"
              :source="formData"
              :buttons="[]"
              ref="form"
              @success="success"
              :scrollable="false">
      <div class="bbn-grid-fields bbn-c">
        <div class="bbn-grid-full bbn-s bbn-no-wrap bbn-vpadded">
          <?= _("You can program the publication for now or the future") ?>
        </div>

        <label><?= _("Publication date") ?></label>
        <bbn-datetimepicker v-model="formData.start"
                            class="bbn-darkgrey"
                            :min="minStart"
                            :max="maxStart"/>

        <div class="bbn-grid-full bbn-s bbn-no-wrap bbn-vpadded">
          <?= _("You can (or not) end a publication") ?>
        </div>

        <label><?= _("End of publication") ?></label>
        <bbn-datetimepicker v-model="formData.end"
                            :disabled="!formData.start"
                            class="bbn-darkgrey"
                            :min="minEnd"/>

        <label> </label>
        <div class="bbn-vpadded">
          <bbn-button class="bbn-no-radius bbn-bg-black bbn-white"
                      :text="_('Confirm')"
                      icon="nf nf-mdi-file_send"
                      @click="$refs.form.submit()"/>
        </div>
      </div>
    </bbn-form>
  </div>
</div>
