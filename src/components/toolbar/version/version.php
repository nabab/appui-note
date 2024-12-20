<div class="bbn-header bbn-spadding bbn-vmiddle">
  <div class="bbn-flex-width bbn-vmiddle">
    <div class="bbn-flex-fill">
      <span><?= _('Version') ?>: </span>
      <span bbn-text="currentVersion"></span>
      <span class="bbn-hsmargin">|</span>
      <span bbn-text="currentDate"></span>
      <span class="bbn-hsmargin">|</span>
      <span bbn-text="currentCreator"></span>
    </div>
    <div bbn-if="hasVersions">
      <span><?= _('Versions') ?>: </span>
      <bbn-dropdown :source="dataUrl"
                    :data="{
                      id: data.id
                    }"
                    bbn-model="currentVersion"
                    :map="map"
      ></bbn-dropdown>
    </div>
  </div>
</div>