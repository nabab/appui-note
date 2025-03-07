<!-- HTML Document -->
<div class="bbn-overlay bookmarks-container">
  <bbn-splitter orientation="horizontal">
    <bbn-pane size="50%"
    >
			<div class="bbn-100">
        <div class="bbn-padding button-container">
          <bbn-button icon="nf nf-fa-star"
                      class="bbn-padding star"
                      @click="showFormLinkM"
                      title="<?= _('New bookmark') ?>"
                      label="<?= _('New bookmark') ?>"/>
          <bbn-button icon="nf nf-fa-folder_plus"
                      class="bbn-padding"
                      @click="showFormFolderM"
                      title="<?= _('New folder') ?>"
                      label="<?= _('New folder') ?>"/>
        </div>
        <div class="bbn-100">
          <bbn-tree bbn-if="!remakeTree"
                    :source="filter"
                    @select="select"
                    class="bbn-medium"
          ></bbn-tree>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane>
      <appui-note-bookmarks-link bbn-if="showFormLink && !showFormFolder" :source="showLink"
      >
      </appui-note-bookmarks-link>
      <appui-note-bookmarks-folder bbn-else-if="showFormFolder && !showFormLink" :source="showFolder"
      ></appui-note-bookmarks-folder>
      <!--appui-note-bookmarks-list bbn-else-if="currentNode && (selectedType === 'folder') && !showFormFolder && !showFormLink">
      </appui-note-bookmarks-list-->
      <appui-note-bookmarks-show bbn-else-if="(showLink.text || showFolder.text) && !showFormFolder && !showFormLink"
                                  :source="{showLink: showLink,showFolder:showFolder}"
      >
      </appui-note-bookmarks-show>


    </bbn-pane>
  </bbn-splitter>
  <!--appui-note-bookmarks-booksform></appui-note-bookmarks-booksform-->
</div>