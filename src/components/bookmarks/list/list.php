<!-- HTML Document -->

<div class="bbn-overlay appui-note-bookmarks-list">
  <bbn-splitter orientation="horizontal"
                :resizable="true">

    <bbn-pane :size="300">
      <div class="bbn-flex-height bbn-overlay">
        <div class="bbn-padded">
          <bbn-button class="bbn-w-80 bbn-spadded"
                      icon="nf nf-fa-plus"
                      @click="newform"
                      text="<?= _('Create a new link') ?>"></bbn-button>
        </div>
        <div><bbn-button class="bbn-w-80 bbn-spadded"
                      icon="nf nf-mdi-clipboard_plus"
                      @click="importing"
                      text="<?= _('Import bookmarks') ?>"></bbn-button>
        </div>
        <div><bbn-button class="bbn-w-80 bbn-spadded"
                      icon="nf nf-mdi-clipboard_plus"
                      @click="deleteAllBookmarks"
                      text="<?= _('Delete all bookmarks') ?>"></bbn-button>
        </div>
        <div class="bbn-flex-fill">
          <div class="bbn-overlay">
            <bbn-tree :source="source.data"
                      ref="tree"
                      @select="selectTree"
                      v-if="source.data.length"
                      :draggable="true"
                      @dragEnd="isDragEnd"
                      ></bbn-tree>
            <label class="bbn-w-100" v-else><?=_("No Bookmarks yet")?></label>
          </div>
        </div>
      </div>
    </bbn-pane>

    <bbn-pane>

      <appui-note-bookmarks-block :source="blockSource" ></appui-note-bookmarks-block>
    </bbn-pane>
  </bbn-splitter>
</div>
