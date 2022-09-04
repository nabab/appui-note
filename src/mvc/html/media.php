<!-- HTML Document -->

<?php
/* Static classes xx and st are available as aliases of bbn\X and bbn\Str respectively */
?>

<bbn-router default="browser"
            :nav="true"
            :autoload="true">
	<bbns-container url="browser"
                  :title="_('Browser')"
                  icon="nf nf-oct-file_media"
                  fcolor="#ccffcc"
                  bcolor="#009688"
                  component="appui-note-media-browser2"
                  :source="root + 'media/data/browser'"
                  :static="true"
                  :options="browserOptions"/>
</bbn-router>
