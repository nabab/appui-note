<!-- HTML Document -->

<div class="bbn-100 appui-note-image-editor">
  <div class="editor_container bbn-100">
  </div>
  <div class="bbn-modal bbn-overlay"
       v-if="showFloater">
  </div>
  <bbn-floater :modal="true"
               v-if="showFloater">
    <appui-note-image-form :file-info="img.imageData"
                           @close="close"
                           @sendinfo="saveInfo"/>
  </bbn-floater>
</div>
