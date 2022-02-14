<!-- HTML Document -->

<div class="appui-note-bookmarks-flex-container"
     :source="source">
  <main>
    <section v-for="block in source" >
      <bbn-context :context="true"
                   :source="contextMenu(block)"
                   tag="div"
                   class="bbn-overlay">
        <div class="url bbn-xspadded">
          <span>
            {{block.text}}
          </span>
        </div>
        <div class="urlT bbn-xspadded">
          <span>
            {{block.text}}
          </span>
        </div>
        <img v-if="block.cover"
             :src="block.cover"
             @click="openUrlSource(block)"
             :text="_('Open the link')"/>
        <div v-else
             class="default-image"
             @click="openUrlSource(block)"
              :text="_('Open the link')"
             />
      </bbn-context>
    </section>
  </main>
</div>