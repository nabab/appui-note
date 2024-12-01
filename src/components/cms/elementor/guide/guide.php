<div :class="['appui-note-cms-elementor-guide', {
       'bbn-w-100': !vertical,
       'bbn-vspadding': !vertical,
       'bbn-h-100': !!vertical,
       'bbn-hspadding': !!vertical,
       'vertical': !!vertical
     }]"
     @mouseover="isOver = true"
     @mouseleave="isOver = false"
     @drop="onDrop">
  <div class="bbn-100"
       :style="{visibility: isVisible ? 'visible' : 'hidden'}"/>
</div>