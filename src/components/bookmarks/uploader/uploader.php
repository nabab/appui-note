<!-- HTML Document -->

<div class="bbn-padded bbn-l-padded"
     style="min-width: 50em margin-left: 1em">
  <div class="bbn-right-padded">
    <bbn-upload
              :auto-upload="true"
              :download="true"
							:save-url="root + 'actions/bookmarks/import'"
              @success="success"/>
  </div>
</div>