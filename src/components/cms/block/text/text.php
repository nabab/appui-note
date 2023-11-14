<!-- HTML Document -->
<div :class="componentClass">
  <div v-if="mode === 'edit'">
    <bbn-textarea v-model="source.content"
                  style="min-height: 20vh; height: 20em; width: 100%"/>
  </div>
  <div v-else-if="!currentContent && $parent.selectable"
       class="bbn-rel bbn-alt-background bbn-middle bbn-lpadded"
       style="overflow: hidden">
    <i class="bbn-xxxxl nf nf-md-text_box"/>
  </div>
  <div v-else
       v-html="currentContent"
       class="bbn-rel"
       :style="{
         color: source.color ? source.color : undefined,
         textAlign: source.align ? source.align : undefined,
         whiteSpace: 'pre-wrap'
       }"/>
</div>
