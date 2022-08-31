<!-- HTML Document -->

<div class="bbn-w-100 bbn-flex-width">
   <div class="bbn-flex-fill">
      <a :href="root + 'cms/cat/' + source.code + '/editor/' + source.id_note"
         v-text="source.title"/>
   </div>
   <div v-if="start"
        class="bbn-block bbn-left-padding bbn-nowrap"
        v-text="fdate(source.start)"/>
   <div v-if="end"
        class="bbn-block bbn-left-padding bbn-nowrap"
        v-text="fdate(source.end)"/>
</div>
