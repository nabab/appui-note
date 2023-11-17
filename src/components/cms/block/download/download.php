<div :class="componentClass">
  <div v-if="mode === 'edit'">
    <div class="bbn-grid-fields">
      <label v-text="_('Orientation')"/>
      <bbn-radiobuttons v-model="source.orientation"
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
              v-text="_('Files')"/>
        <bbn-button icon="nf nf-fa-plus"
                    :title="_('Add more')"
                    @click="addItem"
                    :notext="true"/>
      </div>
      <div/>
    </div>
    <div v-for="(f, i) in source.content"
         class="bbn-top-space bbn-bordered bbn-radius bbn-spadded bbn-grid-fields"
         style="border-style: dashed">
      <label v-text="_('Type')"/>
      <bbn-radiobuttons :source="types"
                        v-model="f.type"
                        @input="onChangeType(f)"/>
      <template v-if="f.type === 'media'">
        <label v-text="_('Media')"/>
        <div class="bbn-flex">
          <bbn-button icon="nf nf-cod-file_media"
                      :notext="true"
                      @click="openExplorer(f)"
                      :title="_('Select a media')"
                      class="bbn-right-sspace"/>
          <span v-text="f.filename"
                style="align-self: center"/>
        </div>
      </template>
      <template v-if="f.type === 'url'">
        <label v-text="_('URL')"/>
        <bbn-input v-model="f.value"
                   class="bbn-w-100"/>
      </template>
      <label v-text="_('Text')"/>
      <bbn-input v-model="f.text"
                class="bbn-w-100"/>
    </div>
  </div>
  <div v-else-if="$parent.selectable && (!source.content?.length || ((source.content.length === 1) && !source.content[0].value?.length))"
        class="bbn-alt-background bbn-middle bbn-lpadded"
        style="overflow: hidden">
    <i class="bbn-xxxxl nf nf-md-download_box"/>
  </div>
  <div v-else
       class="bbn-flex-wrap"
       :style="currentStyle">
    <span v-for="(f, i) in source.content"
          class="bbn-p bbn-xspadded bbn-bordered bbn-radius bbn-reactive"
          @click="onDownload(f)"
          style="width: max-content">
      <i class="nf nf-md-download"/>
      <span v-text="f.text"/>
    </span>
  </div>
</div>