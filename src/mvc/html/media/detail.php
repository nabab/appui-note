<bbn-splitter orientation="vertical"
              class="appui-note-media-detail">
  <bbn-pane>
    <div class="bbn-padded bbn-100 bbn-c">
      <img :src="source.media.path">
    </div>
  </bbn-pane>
  <bbn-pane :size="300">
    <appui-note-media-form :source="source.media"
                           :multiple="false"
                           :url="root + 'media/actions/edit'"
                           class="bbn-overlay"
                           :scrollable="true"
                           @hook:mounted="setOn"
                           ref="form"
                           :buttons="['submit']"/>
  </bbn-pane>
</bbn-splitter>