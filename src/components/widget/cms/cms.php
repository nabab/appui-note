<!-- HTML Document -->

<div class="appui-note-widget-cms bbn-w-100 bbn-flex-width">
   <div class="bbn-flex-fill">
      <a :href="root + 'cms/cat/' + source.code + '/editor/' + source.id_note"
         v-text="source.title"
         :class="{
            'bbn-i': !isPublished
         }"/>
   </div>
   <div class="bbn-block bbn-left-padding ">
    <div class="bbn-nowrap bbn-s"
         v-text="fdate(source.creation)"
         :title="_('Last modification date')"/>
    <div class="bbn-nowrap bbn-s bbn-green"
         v-text="fdate(source.start)"
         :title="_('Publication date')"/>
    <div v-if="end"
         class="bbn-nowrap bbn-s bbn-red"
         v-text="fdate(source.end)"
         :title="_('Unpublication date')"/>
   </div>
</div>
