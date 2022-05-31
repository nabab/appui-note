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
      <div class="bbn-lpadding bbn-postit-container bbn-w-100 bbn-flex"
           style="justify-content: center; align-items: center; flex-wrap: wrap; min-height: 100%">
        <appui-note-postit v-if="newPostIt"
                           :source="newPostIt"
                           @save="onSave"/>
        <div style="width: 20em; height: 20em;"
             v-else
             class="bbn-p bbn-bordered bbn-reactive bbn-radius"
             @click.stop.prevent="add">
          <div class="bbn-100 bbn-middle">
            <div class="bbn-block">
              <i class="bbn-xxxxl nf nf-fa-plus"
                 :title="_('Add a new Post-It')"/>
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
