<!-- HTML Document -->

<bbn-router :nav="true">
  <bbn-container url="home"
                 fcolor="#FFF"
                 bcolor="#063B69"
                 :static="true"
                 :source="source"
                 component="appui-note-cms-dashboard"
                 title="<?= _("Home") ?>"/>
  <bbn-container url="posts"
                 :static="true"
                 :source="source"
                 component="appui-note-cms-list"
                 :title="_('Posts')"/>
  <bbn-container url="import"
                 :static="true"
                 :load="true"
                 :title="_('WP Importer')"/>
</bbn-router>
