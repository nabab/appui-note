<div class="bbn-overlay appui-note-notes-browser">
  <bbn-splitter :resizable="true"
                :collapsible="true"
                orientation="horizontal">
    <bbn-pane :size="250"
              :scrollable="false">
      <div class="bbn-w-100 bbn-flex-height">
        <bbn-toolbar :source="toolbarButtons"/>
        <div class="bbn-flex-fill">
          <bbn-tree :source="appui.plugins['appui-note'] + '/folders/data'"
                    :scrollable="true"
                    uid="id"
                    :drag="true"
                    @move="onMove"
                    @registernode="onRegisterNode"
                    @beforeselect="onSelect"
                    @beforeunselect="onUnselect"
                    :menu="folderMenu"
                    ref="tree"/>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane :scrollable="false">
      <div class="bbn-flex-height">
        <div class="bbn-w-100 bbn-c bbn-vlpadding">
          <bbn-input class="bbn-xxl"
                     placeholder="<?= _("Search") ?>"
                     bbn-model="filterString"
                     autocomplete="off"
                     :nullable="true"
                     style="width: 75%"/>
        </div>
        <div class="bbn-w-100 bbn-flex-fill">
          <bbn-scroll>
            <div class="bbn-lhpadding bbn-bottom-lpadding appui-note-postit-container bbn-flex"
                 style="justify-content: center; align-items: center; flex-wrap: wrap; min-height: 100%">
              <bbn-block-list :source="appui.plugins['appui-note'] + '/notes/list'"
                              ref="list"
                              :pageable="true"
                              :limit="18"
                              :filters="currentFilter"
                              :filterable="true"
                              :multifilter="true"
                              :limits="[]"
                              :max-columns="3"
                              @startloading="startloading"
                              @datareceived="datareceived"
                              component="appui-note-postit"
                              :component-options="{drag: true}"
                              :component-events="{save: onSave, dragend: onDragEnd, beforedrop: onDrop}"/>
              <!--appui-note-postit bbn-if="newPostIt"
                        :source="newPostIt"
                                 @save="onSave"/>
              <div style="width: 20em; height: 20em;"
                   bbn-else
                   class="bbn-p bbn-border bbn-reactive bbn-radius bbn-middle">
                <div class="bbn-block">
                  <i class="bbn-xxxxl nf nf-fa-plus"
                     :title="_('Add a new Post-It')"/>
                </div>
              </div>
              <appui-note-postit bbn-for="note in source.notes"
                                 :key="note.id"
                                 :uid="note.id"
                                 :show-pinned="true"
                                 :source="note"
                                 @save="onSave"/-->
            </div>
          </bbn-scroll>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>

      
