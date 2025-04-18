<div class="appui-note-media-groups bbn-flex-width">
  <div class="bbn-flex-height appui-note-media-groups-panel bbn-border-right">
    <div class="bbn-spadding bbn-header bbn-flex-width bbn-vmiddle appui-note-media-groups-toolbar">
      <bbn-button title="<?= _('New') ?>"
                  icon="nf nf-fa-plus"
                  :notext="true"
                  @click="create"/>
      <bbn-button title="<?= _('Rename') ?>"
                  icon="nf nf-fa-edit"
                  :notext="true"
                  class="bbn-left-xsspace"
                  :disabled="!current"
                  @click="rename"/>
      <bbn-button title="<?= _('Delete') ?>"
                  icon="nf nf-fa-trash"
                  :notext="true"
                  class="bbn-left-xsspace"
                  :disabled="!current"
                  @click="remove"/>
      <div class="bbn-flex-fill bbn-r bbn-left-xsspace">
        <bbn-button title="<?= _('Refresh') ?>"
                    icon="nf nf-fa-refresh"
                    :notext="true"
                    @click="refresh"/>
      </div>
    </div>
    <div class="bbn-border-bottom bbn-bottom-space bbn-spadding bbn-flex-width bbn-vmiddle">
      <bbn-input bbn-model="search"
                 class="bbn-flex-fill bbn-no-border bbn-no-radius"
                 placeholder="<?= _('Search') ?>"/>
      <i :class="['bbn-lg', 'bbn-p', {
           'nf nf-fa-close bbn-red': !!search.length,
           'nf nf-fa-search': !search.length
         }]"
         @click="search = ''"/>
    </div>
    <div :class="['bbn-rel', {'bbn-flex-fill': scrollable}]">
      <bbn-scroll>
        <bbn-list :source="sourceUrl"
                  ref="list"
                  @select="item => current = item"
                  :selection="true"
                  :limit="50"
                  uid="id"
                  mode="selection"
                  source-value="id"
                  class="appui-note-media-groups-list"
                  :pageable="true"
                  :filterable="true"
                  @ready="listMounted = true"/>
      </bbn-scroll>
    </div>
    <div class="bbn-top-space">
      <bbn-pager bbn-if="listMounted"
                 :element="getRef('list')"
                 :limit="false"
                 :extra-controls="false"/>
    </div>
  </div>
  <div class="bbn-flex-fill bbn-rel">
    <appui-note-media-browser bbn-if="current"
                               ref="mediaBrowser"
                               :source="groupMediasUrl"
                               source-action=""
                               :data="{
                                 idGroup: current.id
                               }"
                               :removed="actionsUrl + 'remove'"
                               :toolbar-buttons="[{
                                 title: _('Insert'),
                                 icon: 'nf nf-fa-plus',
                                 notext: true,
                                 action: openAddMediaForm
                               }]"
                               :selection="false"
                               :limit="50"
                               path-name="path"
                               @clickitem="insertLink"
                               :zoomable="false"
                               @delete="removeMedia"
                               :edit="actionsUrl + 'edit'"
                               :detail="mediasDetailUrl"
                               :sortable="true"
                               source-order="position"
                               :server-sorting="false"
                               @sort="sort"/>
    <div bbn-else
         :class="['bbn-middle', {'bbn-overlay': scrollable}]">
      <div class="bbn-vmiddle">
        <i class="nf nf-fa-long_arrow_left bbn-lg bbn-right-xsspace"/>
        <span class="bbn-b bbn-upper bbn-lg"><?= _('Select one or create new') ?></span>
      </div>
    </div>
  </div>
</div>