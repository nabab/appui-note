<!-- HTML Document -->

<div class="bbn-overlay appui-note-bookmarks-manager">
  <bbn-splitter orientation="horizontal"
                :resizable="true">

    <bbn-pane :size="300" class="bbn-flex-height">
      <div class="bbn-padded">
        <bbn-button class="bbn-w-80 bbn-spadded"
                    icon="nf nf-fa-plus"
                    @click="newform"
                    text="<?= _('Create a new link') ?>"></bbn-button>
      </div>
      <div class="bbn-flex-fill">
        <bbn-tree :source="currentSource"
                  ref="tree"
                  @select="selectTree"
                  v-if="currentSource.length"
                  :draggable="true"
                  @dragEnd="isDragEnd"
                  ></bbn-tree>
        <label class="bbn-w-100" v-else><?=_("No Bookmarks yet")?></label>
      </div>
    </bbn-pane>

    <bbn-pane>
      <!--<div>
        <div class="bbn-w-100 bbn-padded" v-if="currentData.id === null">
          <bbn-button class="bbn-padded " text="<?= _('Add Link') ?>" @click="add"></bbn-button>
        </div>
        <div class="bbn-w-100 bbn-lpadded" v-else>
          <bbn-button class="bbn-lpadded " text="<?= _('Modify Link') ?>" @click="modify"></bbn-button>
          <bbn-button class="bbn-lpadded"
                      text="<?= _('Delete Link') ?>"
                      @click="deletePreference"></bbn-button>
        </div>
      </div>-->
      <appui-note-bookmarks-block :source="blockSource" ></appui-note-bookmarks-block>
    </bbn-pane>
  </bbn-splitter>
</div>
