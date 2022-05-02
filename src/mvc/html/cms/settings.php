<!-- HTML Document -->
<div class="bbn-flex-width">
  <div class="bbn-block bbn-padded bbn-c">
    <div class="bbn-vspadded bbn-lg">
      <bbn-list source-value="id"
                :source="source.types"
                ref="list"
                @select="a => id_type = a.id"
                @ready="selectDefault"
                placeholder="<?= st::escape(_('Pick a type')) ?>"/>
    </div>
  </div>
  <div class="bbn-flex-fill bbn-padded bbn-middle">
    <div class="bbn-bordered bbn-border2 bbn-margin bbn-lpadded bbn-radius"
         style="width: 35em; min-width: 30vw; max-width: 90vw"
         v-if="id_type">
      <bbn-form :action="root + 'cms/actions/settings'"
                :key="currentType.id"
                :source="currentType">
        <div class="bbn-grid-fields">
          <label><?= _("Name") ?></label>
          <bbn-input v-model="currentType.text"/>

          <label><?= _("Code") ?></label>
          <bbn-input v-model="currentType.code"/>

          <label><?= _("URL prefix") ?></label>
          <bbn-input v-model="currentType.prefix"/>

          <label><?= _("Use main image") ?></label>
          <div>
            <bbn-checkbox v-model="currentType.front_img"
                          :value="1"
                          :novalue="0"/>
          </div>

          <label><?= _("Use option column") ?></label>
          <div>
            <bbn-checkbox v-model="currentType.option"
                          :value="1"
                          :novalue="0"/>
          </div>

          <template v-if="currentType.option">
            <label><?= _("Option title") ?></label>
            <bbn-input v-model="currentType.option_title"/>

            <label><?= _("Option root") ?></label>
            <appui-option-input-picker v-model="currentType.id_root_alias"/>
          </template>

          <label><?= _("Editor type") ?></label>
          <bbn-dropdown source-value="id"
                        :source="source.editors"
                        v-model="currentType.id_alias"
                        placeholder="<?= st::escape(_('Pick one...'), true) ?>"/>

          <div class="bbn-grid-full bbn-c"
               v-if="currentEditor && (currentEditor.code === 'bbn-cms')">

            <div class="bbn-bottom-space">
              <bbn-dropdown :source="source.blocks"
                            v-model="blocktype"
                            placeholder="<?= st::escape(_('Select a blocktype here'), true) ?>"/>
            </div>
          </div>
          <template v-if="currentBlockConfig">
            <template v-for="cfg in currentBlockConfig">
              <div class="bbn-label bbn-nowrap"
                   v-text="title"/>
              <div class="bbn-iflex-width">
                <bbn-checkbox label="<?= st::escape(_('Leave default'), true) ?>"
                              @check=""/>
                <bbn-dropdown :source="[{
                                       text: '<?= st::escape(_('Set value'), true) ?>',
                                       value: 'set'
                                       }, {
                                       text: '<?= st::escape(_('Let user decide'), true) ?>',
                                       value: 'user'
                                       }]"/>
              </div>
            </template>
          </template>
        </div>
      </bbn-form>
    </div>
  </div>
</div>
