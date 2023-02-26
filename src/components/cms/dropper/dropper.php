<!-- HTML Document -->

<div
     :title="title + ' - ' + description"
     :class="['appui-note-cms-dropper', 'bbn-spadding', 'bbn-radius', 'bbn-smargin', {
             'bbn-primary': !!special,
             'bbn-secondary': !special
             }]"
     v-draggable.data="{data: {source: {type, special}, cfg: defaultConfig}}"
     style="cursor: grab">
  <i :class="[icon + ' bbn-lg']"/>
  <span class="bbn-s bbn-top-smargin bbn-ellipsis"
        v-text="title"/>
</div>