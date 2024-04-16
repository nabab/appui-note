<!-- HTML Document -->

<?php
/* Static classes xx and st are available as aliases of bbn\X and bbn\Str respectively */
?>

<bbn-router default="browser"
            :nav="true"
            :autoload="true">
	<bbn-container url="browser"
                  :title="_('Browser')"
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
