<div class="appui-note-forum-topic bbn-w-100 bbn-hspadding bbn-top-spadding">
  <appui-note-forum-topic-post :source="source"
                               ref="post"/>
  <!-- Replies -->
  <appui-note-forum-topic-replies bbn-if="showReplies"
                                  :source="forum.source"
                                  :data="{id_alias: source.id}"
                                  ref="replies"
                                  :pageable="forum.pageable"
                                  :limit="forum.pageable ? 10 : 0"
                                  :filterable="forum.filterable"
                                  :filters="filters"/>
</div>
