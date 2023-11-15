<!-- HTML Document -->
<div :class="['bbn-overlay', componentClass]">
  <bbn-table ref="table"
             :source="url"
             :data="{type: currentCategory}"
             :limit="25"
             :info="true"
             :columns="currentColumns"
             :storage="true"
             storage-full-name="appui-cms-list"
             :selection="true"
             :pageable="true"
             :showable="true"
             :sortable="true"
             :filterable="true"
             button-mode="menu"
             :search="true"
             :search-fields="['versions.title', 'bbn_url.url', 'bbn_notes.id', 'versions.excerpt']"
             :resizable="true"
             :order="[{
               field: 'start',
               dir: 'DESC'
             }]"
             :toolbar="toolbarComponent"
             uid="id_note"/>
</div>
