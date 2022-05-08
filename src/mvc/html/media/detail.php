<div class="bbn-overlay bbn-flex-height appui-note-media-detail">
  <div class="bbn-w-100">
    <appui-note-media-editor :source="source.media"
                             :url="root + 'media/actions/edit'"
                             @hook:mounted="setOn"
                             ref="form"/>
  </div>
  <div class="bbn-flex-fill">
    <div class="bbn-100 bbn-middle">
      <div class="bbn-block">
        <img :src="source.media.path">
      </div>
    </div>
  </div>
</div>