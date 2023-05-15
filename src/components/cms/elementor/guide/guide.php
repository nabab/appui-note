<div :class="['appui-note-cms-elementor-guide', {
       'bbn-w-100': !vertical,
       'bbn-vspadded': !vertical,
       'bbn-h-100': !!vertical,
       'bbn-hspadded': !!vertical,
       'bbn-vpadded': !!vertical
     }]"
     @mouseover="isOver = true"
     @mouseleave="isOver = false"
     @drop="e => $emit('drop', e)">
  <div :class="['bbn-100', {vertical: !!vertical}]"
       :style="{visibility: isVisible ? 'visible' : 'hidden'}"/>
</div>