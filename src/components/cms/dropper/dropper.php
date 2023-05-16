<!-- HTML Document -->

<div :title="title + ' - ' + description"
     :class="['appui-note-cms-dropper', 'bbn-spadding', 'bbn-radius', 'bbn-smargin', {
             'bbn-primary': !!special,
             'bbn-secondary': !special
             }]"
     v-draggable.data.mode="{data: {type: 'cmsDropper', source: {type, special}, cfg: defaultConfig, parendUid: _uid}, mode: 'clone'}"
     style="cursor: grab"
     @dragend="e => $emit('dragend', e)"
     @dragstart="e => $emit('dragstart', e)">
  <i :class="[icon + ' bbn-lg']"/>
  <span class="bbn-s bbn-top-smargin bbn-ellipsis"
        v-text="title"/>
</div>