<div :class="[componentClass, 'bbn-margin']">
  <div :style="getStyle"
       :class="getComponentName() + '-container bbn-shadow'">
    <div class="bbn-overlay bbn-flex-height bbn-spadding">
      <div class="bbn-flex-fill bbn-top-lmargin"
           @click.stop="onClickPostIt">
        <bbn-rte v-model="currentText"
                 :floating="true"
                 ref="editor"
                 class="bbn-flex-fill"/>
      </div>
        
      <!--div title="<?= _('Edit Content') ?>"
           class="bbn-p bbn-w-100"
           style="min-height: 50%"
           v-text="html2text(currentText)"
           @click="editMode"
           :contenteditable="editing"
           @blur="changeText('text', $event)"/-->
    </div>
    <div class="bbn-top-left">
      <div class="bbn-flex-width">
        <div :class="getComponentName() + '-buttons'">
          <div class="bbn-block bbn-nowrap bbn-spadding">
            <i @click.stop="showCfg = !showCfg"
               ref="button"
               title="<?= _('Post-it configuration') ?>"
               class="nf nf-fa-cog bbn-lg bbn-p bbn-right-smargin"/>
            <i @click.stop="showInfo = !showInfo"
               ref="info"
               v-if="source.id"
               title="<?= _("Post-it information") ?>"
               class="nf nf-fa-info_circle bbn-lg bbn-p bbn-right-smargin"/>
            <i @click.stop="remove(source.id)"
               ref="info"
               v-if="source.id"
               title="<?= _("Delete this post-it") ?>"
               class="nf nf-fa-trash bbn-lg bbn-p"/>
          </div>
        </div>
        <bbn-editable tabindex="0"
                      title="<?= _('Edit Title') ?>"
                      ref="title"
                      type="inline"
                      class="bbn-c bbn-p bbn-b bbn-lg bbn-b bbn-flex-fill bbn-spadded bbn-small-caps"
                      v-model="currentTitle"
                      @change="changeTitle"/>
        <div class="bbn-block bbn-nowrap">
          <i v-if="source.id"
             class="nf nf-fa-info_circle bbn-lg bbn-invisible"/>
          <i v-if="currentPinned"
             class="nf nf-oct-pin bbn-m"/>
          <i v-else
             class="nf nf-fa-cog bbn-lg bbn-invisible"/>
        </div>
      </div>

    </div>
  </div>
  <bbn-floater v-if="ready && showInfo"
               :title="false"
               @close="showInfo = false"
               :element="$refs.info"
               :width="200"
               :auto-hide="true"
               :height="200">
    <div class="bbn-w-100 bbn-padding"
         @click.stop.prevent>
      <div class="bbn-grid-fields">
        <div>
          <?= _("Version") ?>
        </div>
        <div v-text="source.version"/>

        <div>
          <?= _("Created") ?>
        </div>
        <div v-text="fdate(source.creation)"/>

      </div>
    </div>

  </bbn-floater>
  <bbn-floater v-if="ready && showCfg"
               :title="false"
               @close="showCfg = false"
               :element="$refs.button"
               :width="200"
               :auto-hide="true"
               :height="200">
    <div class="bbn-w-100 bbn-padding"
         @click.stop.prevent>
      <div class="bbn-grid-fields">
        <div>
          <?= _("Post-it color") ?>
        </div>
        <div>
          <bbn-colorpicker :preview="true"
                           :palette="palette"
                           :auto-select="true"
                           :cfg="{
                                 columns: 5,
                                 tileSize: 32
                                 }"
                           v-model="currentBcolor"
                           ref="colorpicker"/>
        </div>

        <div>
          <?= _("Pen color") ?>
        </div>
        <div>
          <bbn-colorpicker :preview="true"
                           :palette="['#000000', '#FFFFFF']"
                           :auto-select="true"
                           :cfg="{
                                 columns: 5,
                                 tileSize: 32
                                 }"
                           v-model="currentFcolor"
                           ref="fcolorpicker"/>
        </div>

        <div v-if="showPinned"
             class="bbn-nowrap">
          <?= _("Pinned") ?><br>
          <span v-if="currentPinned"><?= _('It will be removed from the Pinned post-its panel') ?></span>
          <span v-else><?= _('It will be added to the pinned post-its panel') ?></span>
        </div>
        <div v-if="showPinned">
          <bbn-checkbox :value="1"
                        :novalue="0"
                        v-model="currentPinned"/>
        </div>

      </div>
    </div>
  </bbn-floater>
</div>
