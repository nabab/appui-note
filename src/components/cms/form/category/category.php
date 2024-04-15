<bbn-form :action="root + 'cms/actions/type/' + (!!source.id ? 'update' : 'insert')"
          ref="form"
          :source="source"
          @success="onSuccess">
  <div class="bbn-grid-fields bbn-padded">
    <label class="bbn-label"
           bbn-text="_('Text')"/>
    <bbn-input bbn-model="source.text"
               required/>
    <label class="bbn-label"
           bbn-text="_('Code')"/>
    <bbn-input bbn-model="source.code"
               required/>
    <label class="bbn-label"
           bbn-text="_('Front image')"/>
    <bbn-checkbox bbn-model="source.front_img"
                  :value="1"
                  :novalue="0"/>
    <label class="bbn-label"
           bbn-text="_('Prefix')"/>
    <bbn-input bbn-model="source.prefix"/>
  </div>
</bbn-form>