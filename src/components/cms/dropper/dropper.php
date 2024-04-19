<!-- HTML Document -->

<div :title="title + ' - ' + description"
     :class="['appui-note-cms-dropper', 'bbn-spadding', 'bbn-radius', 'bbn-smargin', 'bbn-reactive', 'bbn-middle', {
       'bbn-tertiary': !!special,
       'bbn-background bbn-text': !special
     }]"
     bbn-draggable.data.mode="{
       data: {
         type: 'cmsDropper',
         source: {type, special},
         cfg: defaultConfig,
         parendUid: $cid
       },
       mode: 'clone'
     }">
  <i :class="[icon, ' bbn-xl']"/>
  <span class="bbn-s bbn-top-smargin"
        bbn-text="title"/>
</div>
