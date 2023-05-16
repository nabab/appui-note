<div :class="['appui-note-cms-elementor-guide', {
       'bbn-w-100': !vertical,
       'bbn-vspadded': !vertical,
       'bbn-h-100': !!vertical,
       'bbn-hspadded': !!vertical,
       'bbn-vpadded': !!vertical,
       'vertical': !!vertical
     }]"
     @mouseover="isOver = true"
     @mouseleave="isOver = false"
     @drop="onDrop">
  <div class="bbn-100"
       :style="{visibility: isVisible ? 'visible' : 'hidden'}"/>
</div>