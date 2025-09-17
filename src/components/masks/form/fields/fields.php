<div class="appui-note-masks-form-fields bbn-block"
     :style="{marginLeft: level > 1 ? ('calc(' + level + '* 0.5rem)') : 0}">
  <div class="bbn-flex-width">
    <bbn-icon bbn-if="level"
              content="nf nf-md-arrow_right_bottom"/>
    <div class="bbn-flex-fill bbn-flex-wrap bbn-grid-xxsgap">
      <span bbn-for="f in source"
            :class="['bbn-xspadding', 'bbn-radius', 'bbn-light', 'bbn-p', {
              'bbn-secondary': f !== selected,
              'bbn-state-selected': f === selected
            }]"
            @click="selectField(f)">
        <span bbn-text="f.field"/>
        <span bbn-if="f.items?.length"
              class="bbn-radius bbn-bg-white bbn-secondary-text-alt bbn-hxspadding"
              bbn-text="f.items.length"/>
      </span>
    </div>
  </div>
  <appui-note-masks-form-fields bbn-if="selectedItems?.length"
                                :source="selectedItems"
                                :level="level + 1"
                                class="bbn-top-sspace"/>
</div>
