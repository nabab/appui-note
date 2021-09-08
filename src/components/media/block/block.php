<!-- HTML Document -->
<div :class="componentClass">
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

