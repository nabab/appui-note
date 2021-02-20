<div class="bbn-flex-height bbn-background bbn-overlay" ref="browser">
  <div v-if="filterable"
       class="bbn-w-100 bbn-lpadded">
    <div class="bbn-middle bbn-c">
      <bbn-input placeholder="Search in media"
                 v-model="searchMedia"
                 class="search bbn-xl bbn-w-50"
                 ref="search"/>
      <bbn-button :notext="true"
                  @click="addMedia"
                  class="bbn-xl bbn-margin"
                  icon="nf nf-fa-plus"/>
    </div>
  </div>

  <div class="bbn-flex-fill appui-note-media-browser bbn-lpadded"
       v-if="filteredData.length">
  	<bbn-scroll ref="scroll">
      <ul ref="ul">
        <li class="bbn-block media-block"
            @mouseover="showList = i"
            v-for="(m, i) in filteredData">
        	<component :is="$options.components['block']"
                     :data="{media:m.data, idx:i}"
                     :key="i"/>
          <component :is="$options.components['list']"
                     :data="{media:m.data, idx:i}"
                     :key="i + 1000"
                     v-if="showList === i"/>
        </li>
			</ul>
    </bbn-scroll>
  </div>

  <div class="bbn-w-100">
    <bbn-pager v-if="filteredData.length"
               :element="this"/>
  </div>

	<script type="text/x-template" id="appui-note-media-browser-block">
  	<div class="media-browser-context">
      <div :title="data.media.title"
           class="btn bbn-header media-el-btn"
           :style="data.media.is_image ? 'padding: 0' : ''"
           @click="routeClick(data.media)"
        >
        <!--i v-if="!data.media.is_image && icons[data.media.content.extension] "
           :class="['bbn-xxxl',
                   icons[data.media.content.extension]
                   ]">
        </i>
        <div v-if="!data.media.is_image && !icons[data.media.content.extension]"
             v-text="data.media.content.extension"
             class="bbn-large bbn-badge"
             style="margin-top:50%"
             >

        </div-->
        <div class="media-img-preview bbn-middle"
        >
          <img :src="root + 'media/image/'+ data.media.id">
        </div>
      </div>
      <div class="media-title">
        <div @click.right="editinline = true"
              v-text="cutted"
              :title="data.media.title"
              v-if="!editinline"/>
        <bbn-input v-if="editinline"
                    @click.stop.prevent="focusInput"
                    v-model="data.media.title"
                    @mouseleave="exitEdit"
                    @keyup.enter="exitEdit"
                    @blur="exitEdit"/>
      </div>
      </div>
	</script>
</div>