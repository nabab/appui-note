<div class="bbn-flex-height bbn-background bbn-lpadded bbn-overlay" ref="browser">
  <div class="bbn-line-breaker bbn-middle bbn-c bbn-padded">
    <bbn-input placeholder="Search in media"
               bbn-model="searchMedia"
               class="search bbn-xl bbn-w-50"
               ref="search"
    ></bbn-input>
    <bbn-button :notext="true"
                @click="addMedia"
                class="bbn-xl bbn-margin"
                icon="nf nf-fa-plus"
    ></bbn-button>
  </div>
  
  <div class="bbn-h-100 bbn-flex-fill appui-note-media-browser"
       bbn-if="medias.length"
  >
  	<bbn-scroll ref="scroll">
      <ul ref="ul">
        <li bbn-if="medias.length" 
            class="bbn-block media-block" 
            @mouseover="showList = i" 
            bbn-for="(m, i) in medias">
        	<component :is="$options.components['block']"
                     :data="{media:m, idx:i}"
                     :key="i"
                     
          ></component> 
          
          <component :is="$options.components['list']"
                     :data="{media:m, idx:i}"
                     :key="i + 1000"
                     bbn-if="showList === i"
  				></component> 
        </li>     
			</ul>  
    </bbn-scroll>  
  </div>
  
	<script type="text/x-template" id="block">
  	<div class="media-browser-context">
      <div :title="data.media.title"
           class="btn bbn-header media-el-btn"
           :style="data.media.is_image ? 'padding: 0' : ''"
           @click="routeClick(data.media)"
        >
        <i bbn-if="!data.media.is_image && icons[data.media.content.extension] "
           :class="['bbn-xxxl',
                   icons[data.media.content.extension] 
                   ]">
        </i>
        <div bbn-if="!data.media.is_image && !icons[data.media.content.extension]"
             bbn-text="data.media.content.extension"
             class="bbn-large bbn-badge"
             style="margin-top:50%"
             >

        </div>
        <div bbn-else 
             class="media-img-preview bbn-middle"
        >
          <img :src="root + '/image/'+ data.media.id">
        </div>
      </div>
      <div class="media-title">
        <div @click.right="editinline = true"
              bbn-text="cutted"
              :title="data.media.title"
              bbn-if="!editinline"
              ></div>
        <bbn-input bbn-if="editinline" 
                    @click.stop.prevent="focusInput"
                    bbn-model="data.media.title"
                    @mouseleave="exitEdit"
                    @keyup.enter="exitEdit"
                    @blur="exitEdit"
        ></bbn-input>      
      </div>
      </div>
	</script>
</div>