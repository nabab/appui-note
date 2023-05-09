<div>
  <appui-note-postits v-if="showPostIt"
                      :source="postits"
                      @close="showPostIt = false"/>
</div>
