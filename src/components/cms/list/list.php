<!-- HTML Document -->
<div :class="['bbn-overlay', componentClass]">
  <bbn-table ref="table"
             :source="url"
             :limit="25"
             :info="true"
             :columns="currentColumns"
             :storage="true"
             :selection="true"
             :pageable="true"
             :showable="true"
             :sortable="true"
             :filterable="true"
             button-mode="menu"
  					 :toolbar="$options.components['toolbar']">
  </bbn-table>
</div>
