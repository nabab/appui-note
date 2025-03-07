<!-- HTML Document -->

<div class="bbn-overlay appui-note-bookmarks-list">
  <bbn-splitter orientation="horizontal"
                :resizable="true">

    <bbn-pane :size="300">
      <div class="bbn-flex-height bbn-overlay">
        <bbn-toolbar :source="toolbarSource">
          </bbn-toolbar>
        <div class="bbn-flex-fill">
          <div class="bbn-overlay">
            <bbn-tree :source="source.data"
                      ref="tree"
                      @select="selectTree"
                      bbn-if="source.data.length"
                      :drag="true"
                      @dragend="isDragEnd"
                      ></bbn-tree>
            <label class="bbn-w-100" bbn-else><?= _("No Bookmarks yet") ?></label>
          </div>
        </div>
      </div>
    </bbn-pane>

    <bbn-pane>

      <appui-note-bookmarks-block :source="blockSource" ></appui-note-bookmarks-block>
    </bbn-pane>
  </bbn-splitter>
</div>
