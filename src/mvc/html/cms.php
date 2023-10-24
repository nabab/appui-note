<!-- HTML Document -->

<bbn-router :nav="true">
  <bbn-container url="home"
                 fcolor="#FFF"
                 bcolor="#063B69"
                 :static="true"
                 :source="source"
                 component="appui-note-cms-dashboard"
                 title="<?= _("Home") ?>"/>
  <bbn-container v-for="t in source.types_notes"
                 :key="'cat/' + t.code"
                 :url="'cat/' + t.code"
                 :source="source"
                 :static="true"
                 fcolor="#FFF"
                 bcolor="#063B69"
                 :title="t.text">
    <bbn-router :nav="true"
                :storage="true"
                :autoload="true"
                :base-url="'cat/' + t.code + '/'">
      <bbn-container url="list"
                     :source="source"
                     component="appui-note-cms-list"
                     :options="{id_type: t.id, noteName: _('Article')}"
                     :static="true"
                     fcolor="#FFF"
                     bcolor="#063B69"
                     title="<?= _("Articles' list") ?>"/>
    </bbn-router>
  </bbn-container>
</bbn-router>
