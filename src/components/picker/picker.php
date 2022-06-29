<!-- HTML Document -->

<div class="bbn-w-100">
  <bbn-search :source="root + 'cms/data/search'"
              source-url=""
              :data="{types: types}"
              component="appui-note-search-item"
              @select="select"/>
</div>