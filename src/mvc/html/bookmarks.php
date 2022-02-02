<!-- HTML Document -->

<div class="bbn-overlay appui-note-bookmarks-manager">
  <bbn-splitter orientation="horizontal"
                :resizable="true">

    <bbn-pane :size="300">
      <div class="bbn-w-100 bbn-padded">
        <bbn-button class="bbn-w-80 bbn-spadded"
                    icon="nf nf-fa-plus"
                    @click="newform"
                    text="<?= _('Create a new link') ?>"></bbn-button>
      </div>
      <bbn-tree :source="currentSource"
                ref="tree"
                @select="selectTree"
                v-if="currentSource.length"
                :draggable="true"
                @dragEnd="isDragEnd"
                ></bbn-tree>
      <label class="bbn-w-100" v-else><?=_("No Bookmarks yet")?></label>
    </bbn-pane>

    <bbn-pane :scrollable="true">
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

      <div class="appui-note-bookmarks-flex-container">
        <main>
          <section v-for="block in blockSource" v-if="block.cover">
            <bbn-context :context="true"
                         :source="contextMenu(block)"
                         tag="div">
              <div class="url bbn-xspadded">
                <span>
                  {{block.text}}
                </span>
              </div>
              <div class="urlT bbn-xspadded">
                <span>
                  {{block.text}}
                </span>
              </div>
              <img :src="block.cover"
                   @click="openUrlSource(block)"/>
            </bbn-context>
          </section>
        </main>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>
