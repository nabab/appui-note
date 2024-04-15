<div class="bbn-overlay bbn-flex-height appui-note-media-detail">
  <div class="bbn-w-100">
    <appui-note-media-editor :source="source.media"
                             :url="root + 'media/actions/edit'"
                             @hook:mounted="setOn"
                             ref="form"/>
  </div>
  <div class="bbn-flex-fill bbn-padded">
    <div class="bbn-100 bbn-middle">
      <div class="bbn-block bbn-nowrap">
        <span class="bbn-bottom-space"
              bbn-text="source.media.dimensions.w + ' px x ' + source.media.dimensions.h + ' px'"/><br>
        <div class="bbn-block">
          <img :src="source.media.path">
        </div>
      </div>
    </div>
  </div>
  <div class="bbn-w-100 bbn-middle bbn-top-space">
    <div class="bbn-flex-items">
      <div bbn-for="t in source.media.thumbs"
           class="bbn-c">
        <!--<span bbn-text="t + ' px'"/><br>-->
        <img :src="t">
      </div>
    </div>
  </div>
</div>