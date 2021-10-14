<!-- HTML Document -->

<bbn-router :nav="true"
            :storage="true"
            :base-url="source.root">
  <bbns-container url="list"
                  :load="true"
                  :pinned="true"
                  title="<?= _("Articles' list") ?>"/>
</bbn-router>