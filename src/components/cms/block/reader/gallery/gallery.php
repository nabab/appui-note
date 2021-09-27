<!-- HTML Document -->

<div :class="[componentClass, 'bbn-block-gallery', alignClass, columnsClass]"
     :style="style"
     v-if="show">
  <appui-note-cms-block-reader-gallery-item v-for="(image, idx) in source.source"
                                            :source="image"
                                            :key="idx"
                                            :index="idx"/>
</div>
