<!-- HTML Document -->

<div :class="[componentClass, 'bbn-w-100']">
  <bbn-search :source="root + 'cms/data/search'"
              source-url=""
              :data="{types: types}"
              component="appui-note-search-item"
              :placeholder="placeholder"
              short-placeholder=""
              @select="select"/>
</div>