<bbn-form :action="root + 'cms/actions/type/' + (!!source.id ? 'update' : 'insert')"
          ref="form"
          :source="source"
          @success="onSuccess">
  <div class="bbn-grid-fields bbn-padded">
    <label class="bbn-label"
           v-text="_('Text')"/>
    <bbn-input v-model="source.text"
               required/>
    <label class="bbn-label"
           v-text="_('Code')"/>
    <bbn-input v-model="source.code"
               required/>
    <label class="bbn-label"
           v-text="_('Front image')"/>
    <bbn-checkbox v-model="source.front_img"
                  :value="1"
                  :novalue="0"/>
    <label class="bbn-label"
           v-text="_('Prefix')"/>
    <bbn-input v-model="source.prefix"/>
  </div>
</bbn-form>