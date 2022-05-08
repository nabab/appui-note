<!-- HTML Document -->

<bbn-router :nav="true"
            first="unreal"
            :base-url="source.root">
  <bbn-container url="home"
                 fcolor="#FFF"
                 bcolor="#063B69"
                 :pinned="true"
                 :closable="false"
                 :source="source"
                 component="appui-note-cms-dashboard"
                 title="<?= _("Home") ?>"/>
  <?php foreach ($types_notes as $t) { ?>
  <bbn-container url="cat/<?= $t['code'] ?>"
                 :source="source"
                 :pinned="true"
                 fcolor="#FFF"
                 bcolor="#063B69"
                 :closable="false"
                 title="<?= $t['text'] ?>">
    <bbn-router :nav="true"
                :storage="true"
                :autoload="true"
                base-url="cat/<?= $t['code'] ?>/">
      <bbn-container url="list"
                     :source="source"
                     component="appui-note-cms-list"
                     :options="{id_type: '<?= $t['id'] ?>', noteName: _('Article')}"
                     :pinned="true"
                     fcolor="#FFF"
                     bcolor="#063B69"
                     :closable="false"
                     title="<?= _("Articles' list") ?>"/>
    </bbn-router>
  </bbn-container>
  <?php } ?>
</bbn-router>
