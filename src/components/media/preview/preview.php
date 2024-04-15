<div class="media-browser-context">
  <div :title="data.title"
       class="btn bbn-header media-el-btn"
       :style="data.is_image ? 'padding: 0' : ''"
       >
    <i bbn-if="!data.is_image && icons[data.content.extension] "
       :class="['bbn-xxxl',
               icons[data.content.extension] 
               ]">
    </i>
    <div bbn-if="!data.is_image && !icons[data.content.extension]"
         bbn-text="data.content.extension"
         class="bbn-large bbn-badge"
         style="margin-top:50%"
         >
    </div>
    <img bbn-else 
         @click="showImage(data)"
         class="media-img-preview"
				 :src="'notes/media/image/' + data.id"
				>
  </div>
  <div class="media-title">
    <div bbn-text="cutted"
         :title="data.title"
    ></div>
  </div>  
</div>