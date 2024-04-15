<div class="bbn-flex-height bbn-background bbn-overlay" ref="browser">
  <div bbn-if="filterable"
       class="bbn-w-100 bbn-lpadded">
    <div class="bbn-middle bbn-c">
      <bbn-input placeholder="Search in media"
                 bbn-model="searchMedia"
                 class="search bbn-xl bbn-w-50"
                 ref="search"/>
      <bbn-button :notext="true"
                  @click="addMedia"
                  class="bbn-xl bbn-margin"
                  icon="nf nf-fa-plus"/>
    </div>
  </div>

  <div class="bbn-flex-fill appui-note-media-browser bbn-lpadded"
       bbn-if="filteredData.length">
  	<bbn-scroll ref="scroll">
      <ul ref="ul">
        <li class="bbn-block media-block"
            @mouseover="showList = i"
            bbn-for="(m, i) in filteredData">
        	<component :is="$options.components['block']"
                     :data="{media:m.data, idx:i}"
                     :key="i"/>
          <component :is="$options.components['list']"
                     :data="{media:m.data, idx:i}"
                     :key="i + 1000"
                     bbn-if="showList === i"/>
        </li>
			</ul>
    </bbn-scroll>
  </div>

  <div class="bbn-w-100">
    <bbn-pager bbn-if="filteredData.length"
               :element="this"/>
  </div>

	<script type="text/x-template" id="appui-note-media-browser-block">
  	<div class="media-browser-context">
      <div :title="data.media.title"
           class="btn bbn-header media-el-btn"
           :style="data.media.is_image ? 'padding: 0' : ''"
           @click="routeClick(data.media)"
        >
        <!--i bbn-if="!data.media.is_image && icons[data.media.content.extension] "
           :class="['bbn-xxxl',
                   icons[data.media.content.extension]
                   ]">
        </i>
        <div bbn-if="!data.media.is_image && !icons[data.media.content.extension]"
             bbn-text="data.media.content.extension"
             class="bbn-large bbn-badge"
             style="margin-top:50%"
             >

        </dibbn-->
        <div class="media-img-preview bbn-middle"
        >
          <img :src="root + 'media/image/'+ data.media.id">
        </div>
      </div>
      <div class="media-title">
        <div @click.right="editinline = true"
              bbn-text="cutted"
              :title="data.media.title"
              bbn-if="!editinline"/>
        <bbn-input bbn-if="editinline"
                    @click.stop.prevent="focusInput"
                    bbn-model="data.media.title"
                    @mouseleave="exitEdit"
                    @keyup.enter="exitEdit"
                    @blur="exitEdit"/>
      </div>
      </div>
	</script>
</div>