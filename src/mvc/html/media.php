<!-- HTML Document -->
<bbn-router default="browser"
            :nav="true"
            :autoload="true">
	<bbn-container url="browser"
                  :label="_('Browser')"
                  icon="nf nf-oct-file_media"
                  fcolor="#ccffcc"
                  bcolor="#009688"
                  :fixed="true">
    <div class="bbn-overlay">
      <appui-note-media-browser bbn-bind="browserOptions"
                                 :source="root + 'media/data/browser'"
                                 @delete="onDelete"
                                 ref="mediabrowser"/>
    </div>
  </bbn-container>
</bbn-router>
