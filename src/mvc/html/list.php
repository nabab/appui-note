<!-- HTML Document -->
<div class="bbn-overlay bbn-flex-height">
  <bbn-toolbar>
    <bbn-dropdown :source="source.types"
                  :placeholder="_('All categories')"
                  :nullable="true"
                  v-model="type"/>
  </bbn-toolbar>
  <div class="bbn-flex-fill">
    <bbn-table :sortable="true"
               :filterable="true"
               :filter="{
                        logic: 'AND',
                        conditions: [{
                          field: 'id_type',
                          value: type
                        }]
               }"
               :pageable="true"
               :source="source.root + 'data/notes'">
      <bbns-column field="id"
                   :hidden="true"/>
      <bbns-column field="title"/>
      <bbns-column field="author"/>
    </bbn-table>
  </div>
</div>