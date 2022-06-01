<!-- HTML Document -->

<bbn-floater :title="false"
             :closable="true"
             :modal="true"
             width="100%"
             height="100%"
             @close="$emit('close')"
             ref="floater"
             :scrollable="false">
  <div class="bbn-overlay bbn-middle"
       @click="onClick">
    <div class="bbn-flex bbn-l"
         style="flex-wrap: wrap; max-width: 80%; align-items: center;">
      <appui-note-postit v-for="(pi, idx) in source"
                         :source="pi"
                         @remove="onRemove"
                         @save="onSave($event, idx)"
                         :key="pi.id"/>
      <div style="width: 15rem; height: 15rem; margin: 2.5rem"
           v-if="!hasNew"
           class="bbn-p bbn-white bbn-bordered bbn-reactive bbn-radius"
           @click.stop.prevent="add">
        <div class="bbn-100 bbn-middle">
          <div class="bbn-block">
            <i class="bbn-xxxxl nf nf-fa-plus"
               :title="_('Add a new Post-It')"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</bbn-floater>
