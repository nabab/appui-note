<div class="appui-note-forum-topic-replies">
  <div v-if="isLoading"
       class="bbn-middle bbn-padded">
    <?=_('LOADING')?>...
  </div>
  <div v-else>
    <appui-note-forum-topic-post v-for="(d, i) in filteredData"
                                :source="d.data"
                                :key="d.key"
                                :index="d.index"
                                :class="['bbn-top-smargin', {'bbn-bottom-smargin': !filteredData[i+1]}]"/>
    <bbn-pager v-if="pagerVisible"
               :element="_self"
               class="bbn-no-border bbn-radius"/>
  </div>
</div>