<!-- HTML Document -->

<div :class="[componentClass, 'component-container', 'bbn-block-html', {
       'bbn-overlay': isEditor
     }]">
  <bbn-rte bbn-if="isEditor"
           bbn-model="source.content"
           height="100%"/>
  <div bbn-else-if="!source.content && $parent.selectable"
        class="bbn-alt-background bbn-middle bbn-lpadded"
        style="overflow: hidden">
    <i class="bbn-xxxxl nf nf-fa-html5"/>
  </div>
  <div bbn-else
	     bbn-html="source.content"
       :style="style"/>
</div>
