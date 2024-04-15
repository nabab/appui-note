<!-- HTML Document -->
<div :class="componentClass">
  <div bbn-if="mode === 'edit'">
    <bbn-textarea bbn-model="source.content"
                  style="min-height: 20vh; height: 20em; width: 100%"/>
  </div>
  <div bbn-else-if="!currentContent && $parent.selectable"
       class="bbn-rel bbn-alt-background bbn-middle bbn-lpadded"
       style="overflow: hidden">
    <i class="bbn-xxxxl nf nf-md-text_box"/>
  </div>
  <div bbn-else
       bbn-html="currentContent"
       class="bbn-rel"
       :style="{
         color: source.color ? source.color : undefined,
         textAlign: source.align ? source.align : undefined,
         whiteSpace: 'pre-wrap'
       }"/>
</div>
