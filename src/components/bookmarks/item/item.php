<!-- HTML Document -->

<section class="appui-note-bookmarks-item">
  <bbn-context bbn-if="isVisible"
               :context="true"
               :source="contextMenu(source)"
               tag="div"
               class="bbn-overlay">
    <div @click="openUrlSource(source)">
      <div class="url bbn-xspadded">
      <span>
        {{source.text}}
      </span>
    </div>
    <div class="urlT bbn-xspadded">
      <span>
        {{source.text}}
      </span>
    </div>
    <img bbn-if="source.cover"
         :src="source.cover"
         :text="_('Open the link')"/>
    <div bbn-else
         class="default-image"
         :text="_('Open the link')"
         />
    </div>
  </bbn-context>
</section>