<!-- HTML Document -->

<section class="appui-note-bookmarks-item" >
  <bbn-context v-if="isVisible"
               :context="true"
               :source="contextMenu(source)"
               tag="div"
               class="bbn-overlay">
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
    <img v-if="source.cover"
         :src="source.cover"
         @click="openUrlSource(source)"
         :text="_('Open the link')"/>
    <div v-else
         class="default-image"
         @click="openUrlSource(source)"
         :text="_('Open the link')"
         />
  </bbn-context>
</section>