<!-- HTML Document -->

<bbn-router :nav="true"
            first="unreal"
            :base-url="source.root">
  <bbns-container url="home"
                  :load="true"
                  fcolor="#FFF"
                  bcolor="#063B69"
                  :pinned="true"
                  :closable="false"
                  title="<?= _("Home") ?>"/>
  <?php foreach ($types_notes as $t) { ?>
  <bbn-container url="cat/<?= $t['code'] ?>"
                 :pinned="true"
                 fcolor="#FFF"
                 bcolor="#063B69"
                 :closable="false"
                 title="<?= $t['text'] ?>">
    <bbn-router :nav="true"
                :storage="true"
                base-url="cat/<?= $t['code'] ?>/">
      <bbns-container url="list"
                      :load="true"
                      :pinned="true"
                      fcolor="#FFF"
                      bcolor="#063B69"
                      :closable="false"
                      title="<?= _("Articles' list") ?>"/>
    </bbn-router>
  </bbn-container>
  <?php } ?>
</bbn-router>
