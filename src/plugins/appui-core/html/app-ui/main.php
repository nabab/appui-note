<appui-note-postits bbn-if="showPostIt"
                    @close="showPostIt = false"
                    :storage="true"
                    :source="postits"
                    full-storage-name="appui-note-postits"/>
