<div class="appui-note-forum-topic-replies">
  <div bbn-if="isLoading"
       class="bbn-middle bbn-padding">
    <?= _('LOADING') ?>...
  </div>
  <div bbn-else>
    <appui-note-forum-topic-post bbn-for="(d, i) in filteredData"
                                :source="d.data"
                                :key="d.key"
                                :index="d.index"
                                :class="['bbn-top-smargin', {'bbn-bottom-smargin': !filteredData[i+1]}]"/>
    <bbn-pager bbn-if="pagerVisible"
               :element="_self"
               class="bbn-no-border bbn-radius"/>
  </div>
</div>