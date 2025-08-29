<!-- HTML Document -->
<div class="bbn-overlay bbn-background">
  <bbn-floater :label="false"
              :closable="true"
              :modal="true"
              width="100%"
              height="100%"
              :z-index="10"
              @close="$emit('close')"
              ref="floater"
              :scrollable="true">
    <div class="bbn-w-100 bbn-middle bbn-lpadding"
        @click="onClick">
      <div class="bbn-flex bbn-l"
          style="flex-wrap: wrap; align-items: center;">
        <div style="width: 15rem; height: 15rem; margin: 2.5rem"
            bbn-if="!hasNew"
            class="bbn-p bbn-white bbn-border bbn-reactive bbn-radius bbn-middle"
            @click.stop.prevent="add">
          <div class="bbn-block">
            <i class="bbn-xxxxl nf nf-fa-plus"
              :title="_('Add a new Post-It')"/>
          </div>
        </div>
        <appui-note-postit bbn-for="(pi, idx) in source"
                          :source="pi"
                          @remove="onRemove"
                          @save="onSave($event, idx)"
                          :key="pi.id"/>
      </div>
    </div>
  </bbn-floater>
</div>
