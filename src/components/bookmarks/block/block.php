<!-- HTML Document -->

<div class="bbn-overlay bbn-flex-height appui-note-bookmarks-block">
  <div class="bbn-padded bbn-b">
    <bbn-input placeholder="Search a link"
               class="bbn-w-50"
               v-model="search"></bbn-input>
    <span>
      {{source.length}}
    </span>
    <label><?=_("links")?></label>
  </div>

  <div class="bbn-flex-fill" >
    <bbn-scroll ref="scroll"
                @scroll="scrolling"
                @resize="resize"
                @ready="update"
                @reachBottom="addItems">
      <appui-note-bookmarks-item v-for="block in currentItems"
                                 :source="block"
                                 :key="block.id"
                                 :scroll-size="scrollSize"
                                 :container-size="containerSize"
                                 :scroll-top="scrolltop"
                                 :width="currentWidth"
                                 :ref="'item-'+ block.id"
                                 />
    </bbn-scroll>
  </div>
</div>