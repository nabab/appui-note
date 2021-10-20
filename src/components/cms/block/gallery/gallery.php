<!-- HTML Document -->
<div :class="componentClass">
  <div v-if="mode === 'edit'"
       class="bbn-grid-fields bbn-padded">
    <label><?=_('Gallery')?></label>
    <div class="bbn-vmiddle">
      <bbn-dropdown :source="galleries"
                    v-model="source.source"/>
      <bbn-button icon="nf nf-fae-galery"
                  :notext="true"
                  @click="openMediasGroups"
                  class="bbn-left-sspace"/>
    </div>
    <label><?=_('Scrollable')?></label>
    <bbn-checkbox v-model="source.scrollable"
                  :value="1"
                  :novalue="0"/>
    <label><?=_('Pageable')?></label>
    <bbn-checkbox v-model="source.pageable"
                  :value="1"
                  :novalue="0"/>
    <label><?=_('Zoomable')?></label>
    <bbn-checkbox v-model="source.zoomable"
                  :value="1"
                  :novalue="0"/>
    <label><?=_('Resizable')?></label>
    <bbn-checkbox v-model="source.resizable"
                  :value="1"
                  :novalue="0"/>
    <label><?=_('Toolbar')?></label>
    <bbn-checkbox v-model="source.toolbar"
                  :value="1"
                  :novalue="0"/>
  </div>
  <div v-else>
    <bbn-gallery :source="gallerySourceUrl"
                 :data="{
                   idGroup: source.source
                 }"
                 ref="gallery"
                 :scrollable="!!source.scrollable"
                 :pageable="!!source.pageable"
                 :zoomable="!!source.zoomable"
                 :resizable="!!source.resizable"
                 :toolbar="!!source.toolbar"
                 path-name="path"/>
  </div>
</div>
