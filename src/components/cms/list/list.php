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
             :search="true"
             :search-fields="['versions.title', 'bbn_url.url', 'bbn_notes.id', 'versions.excerpt']"
  					 :toolbar="[{
                       icon: 'nf nf-fa-plus',
                       text: _('Insert Articles'),
                       action: insertNote
                       }]">
  </bbn-table>
</div>
