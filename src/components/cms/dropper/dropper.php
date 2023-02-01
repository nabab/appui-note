<!-- HTML Document -->

<div
     :title="title + ' - ' + description"
     :class="['appui-note-cms-dropper', 'bbn-spadding', 'bbn-radius', 'bbn-smargin']"
     v-draggable.data="{data: {source: {type}, cfg: defaultConfig}}"
     style="cursor: grab">
  <i :class="[icon + ' bbn-xxxl']"/>
  <span class="bbn-xl bbn-top-smargin bbn-ellipsis"
        v-text="title"/>
</div>