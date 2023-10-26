<!-- HTML Document -->

<div class="appui-note-widget-cms bbn-w-100 bbn-flex-width">
   <div class="bbn-flex-fill">
      <a :href="root + 'cms/cat/' + source.code + '/editor/' + source.id_note"
         v-text="source.title"
         :class="{
            'bbn-i': !isPublished
         }"/>
   </div>
   <div class="bbn-block bbn-left-padding bbn-nowrap bbn-s"
        v-text="fdate(source.start)"/>
   <div v-if="end"
        class="bbn-block bbn-left-padding bbn-nowrap"
        v-text="fdate(source.end)"/>
</div>
