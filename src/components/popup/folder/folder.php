<!-- HTML Document -->

<bbn-form :action="appui.plugins['appui-note'] + '/folders/create'"
          :source="data"
          @success="$emit('success', data)">
  <h2 class="bbn-c" bbn-text="_('New folder')"/>
  <div class="bbn-grid-fields bbn-padding">
    <label bbn-text="_('Folder\'s name')"/>
    <bbn-input bbn-model="data.text"/>
  </div>
</bbn-form>
