<!-- HTML Document -->

<div :title="title + ' - ' + description"
     :class="['appui-note-cms-dropper', 'bbn-spadding', 'bbn-radius', 'bbn-smargin', 'bbn-reactive', 'bbn-middle', {
       'bbn-tertiary': !!special,
       'bbn-background bbn-text': !special
     }]"
     v-draggable.data.mode="{
       data: {
         type: 'cmsDropper',
         source: {type, special},
         cfg: defaultConfig,
         parendUid: _uid
       },
       mode: 'clone'
     }"
     @dragend="e => $emit('dragend', e)"
     @dragstart="e => $emit('dragstart', e)">
  <i :class="[icon, ' bbn-xl']"/>
  <span class="bbn-s bbn-top-smargin"
        v-text="title"/>
</div>