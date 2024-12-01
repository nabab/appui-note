<div :class="componentClass">
  <div bbn-if="mode === 'edit'">
    <div class="bbn-grid-fields">
      <label bbn-text="_('Orientation')"/>
      <bbn-radiobuttons bbn-model="source.orientation"
                        :notext="true"
                        :source="[{
                          text: _('Horizontal'),
                          value: 'horizontal',
                          icon: 'nf nf-cod-split_horizontal'
                        }, {
                          text: _('Vertical'),
                          value: 'vertical',
                          icon: 'nf nf-cod-split_vertical'
                        }]"/>
      <div>
        <span class="bbn-right-sspace"
              bbn-text="_('Files')"/>
        <bbn-button icon="nf nf-fa-plus"
                    :title="_('Add more')"
                    @click="addItem"
                    :notext="true"/>
      </div>
      <div/>
    </div>
    <div bbn-for="(f, i) in source.content"
         class="bbn-w-100 bbn-top-space bbn-border bbn-radius bbn-flex-width"
         style="border-style: dashed">
      <div class="bbn-grid-fields bbn-spadding bbn-flex-fill">
        <label bbn-text="_('Type')"/>
        <bbn-radiobuttons :source="types"
                          bbn-model="f.type"
                          @input="onChangeType(f)"/>
        <template bbn-if="f.type === 'media'">
          <label bbn-text="_('Media')"/>
          <div class="bbn-flex">
            <bbn-button icon="nf nf-cod-file_media"
                        :notext="true"
                        @click="openExplorer(f)"
                        :title="_('Select a media')"
                        class="bbn-right-sspace"/>
            <span bbn-text="f.filename"
                  style="align-self: center; word-break: break-all"/>
          </div>
        </template>
        <template bbn-if="f.type === 'url'">
          <label bbn-text="_('URL')"/>
          <bbn-input bbn-model="f.value"
                     class="bbn-w-100"/>
        </template>
        <label bbn-text="_('Text')"/>
        <bbn-input bbn-model="f.text"
                  class="bbn-w-100"/>
      </div>
      <div class="bbn-middle bbn-xspadding bbn-background bbn-radius-right bbn-reactive bbn-p"
           @click="removeItem(i)"
           bbn-if="source.content?.length > 1">
        <i class="nf nf-fa-trash bbn-red"/>
      </div>
    </div>
  </div>
  <div bbn-else-if="$parent.selectable && (!source.content?.length || ((source.content.length === 1) && !source.content[0].value?.length))"
        class="bbn-alt-background bbn-middle bbn-lpadding"
        style="overflow: hidden">
    <i class="bbn-xxxxl nf nf-md-download_box"/>
  </div>
  <div bbn-else
       class="bbn-flex-wrap"
       :style="currentStyle">
    <span bbn-for="(f, i) in source.content"
          class="bbn-p bbn-xspadding bbn-border bbn-radius bbn-reactive"
          @click="onDownload(f)"
          style="width: max-content">
      <i class="nf nf-md-download"/>
      <span bbn-text="f.text"/>
    </span>
  </div>
</div>