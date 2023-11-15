<div :class="componentClass">
  <div v-if="mode === 'edit'">
    <div class="bbn-middle bbn-bottom-sspace">
      <span class="bbn-upper bbn-right-sspace"><?=_('Files')?></span>
      <bbn-button icon="nf nf-fa-plus"
                  title="<?=_('Add more')?>"
                  @click="addItem"
                  :notext="true"/>
    </div>
    <file v-for="(f, i) in source.content"
          :source="f"
          :key="i"
          :class="{'bbn-bottom-space': !!source.content[i+1]}"/>
  </div>
  <div v-else-if="!source.content?.length && $parent.selectable"
        class="bbn-alt-background bbn-middle bbn-lpadded"
        style="overflow: hidden">
    <i class="bbn-xxxxl nf nf-md-download_box"/>
  </div>
  <div v-else>
    aaaa
  </div>
</div>