<div class="appui-note-forum-topic bbn-w-100 bbn-hspadded bbn-top-spadded">
  <appui-note-forum-topic-post :source="source"
                               ref="post"/>
  <!-- Replies -->
  <appui-note-forum-topic-replies v-if="showReplies"
                                  :source="forum.source"
                                  :data="{id_alias: source.id}"
                                  ref="replies"
                                  :pageable="forum.pageable"
                                  :limit="forum.pageable ? 10 : 0"/>
</div>
