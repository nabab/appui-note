<!-- HTML Document -->
<div :class="['bbn-overlay', componentClass]">
  <bbn-table ref="table"
             :source="url + currentCategory"
             :limit="25"
             :info="true"
             :columns="currentColumns"
             :storage="false"
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
  					 toolbar="appui-note-cms-list-toolbar"
             uid="id_note"/>
</div>

