<!-- HTML Document -->
<div class="bbn-overlay appui-note-square bbn-flex-height">
  <bbn-toolbar class="bbn-spadding">
    <control :source="blockChoice"/>
  </bbn-toolbar>
  <div class="bbn-flex-fill">
    <div class="bbn-100">
      <bbn-scroll>
        <div class="bbn-grid-fields"
             bbn-for="(line, i) in lines"
             tabindex="0">
          <div class="bbn-padding"
               style="width: 160px">
            <control :source="blockChoice" :index="i"/>
          </div>
          <div class="bbn-padding">
            <bbn-cms-block :source="line"
                       ref="block"
                       :index="i"
                       bbn-if="line.type"
            >
            </bbn-cms-block>
            <span bbn-else class="bbn-c bbn-medium bbn-green"><?= ('Select a block type') ?></span>
          </div>
        </div>
      </bbn-scroll>
    </div>
  </div>
</div>