<!-- HTML Document -->

<bbn-router :nav="true"
            :autoload="false"
            first="unreal"
            :base-url="source.root">
  <bbns-container url="home"
                  :load="true"
                  :pinned="true"
                  :closable="false"
                  title="<?= _("Home") ?>"/>
  <?php foreach ($types_notes as $t) { ?>
  <bbn-container url="cat/<?= $t['code'] ?>"
                 :pinned="true"
                 :closable="false"
                 title="<?= $t['title'] ?>">
    <bbn-router :nav="true"
                :storage="true"
                :autoload="true"
                base-url="cat/<?= $t['code'] ?>/">
      <bbns-container url="list"
                      :load="true"
                      :pinned="true"
                      :closable="false"
                      title="<?= _("Articles' list") ?>"/>
    </bbn-router>
  </bbn-container>
  <?php } ?>
</bbn-router>
