<div class="bbn-overlay bbn-flex-height">
  <!--div class="bbn-w-100 bbn-block bbn-c bbn-vmargin"
       style="height: 80px">
    <bbn-input class="bbn-xxl"
               placeholder="<?=_("Search")?>"
               autocomplete="off"
               style="width: 75%"/>
  </div-->
  <div class="bbn-w-100 bbn-flex-fill">
    <bbn-scroll>
      <div class="bbn-lpadding bbn-postit-container bbn-w-100 bbn-flex-fill">
        <appui-note-postit v-if="newPostIt"
                           :source="newPostIt"
                           @save="onSave"/>
        <div v-else
             class="bbn-block"
             style="width: 20em; height: 20em">
          <div class="bbn-100 bbn-middle">
            <div class="bbn-block bbn-xlpadding bbn-bordered bbn-xxl">
              <bbn-button icon="nf nf-fa-plus"
                          :notext="true"
                          @click="add"/>
            </div>
          </div>
        </div>
        <appui-note-postit v-for="note in source.notes"
                           :key="note.id"
                           :uid="note.id"
                           :source="note"
                           @save="onSave"/>
      </div>
    </bbn-scroll>
  </div>
</div>
