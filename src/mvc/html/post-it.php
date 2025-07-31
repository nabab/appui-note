<div class="appui-note-postits bbn-overlay bbn-flex-height">
  <div class="bbn-c bbn-vmargin">
    <bbn-input placeholder="<?= _("Search") ?>"
               autocomplete="off"
               style="width: 75%"
               class="bbn-xl"
               bbn-model="rechercher"/>
  </div>
  <div class="bbn-flex-fill">
    <bbn-scroll>
      <div class="bbn-postit-container">
        <appui-note-postit bbn-for="(note, index) in notes"
                           :source="note"
                           @remove="removeItem"
                           :key="note.id"/>
      </div>
    </bbn-scroll>
  </div>
</div>
