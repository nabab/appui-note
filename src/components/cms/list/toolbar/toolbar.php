<bbn-toolbar class="appui-note-cms-list-toolbar bbn-header bbn-hspadded bbn-h-100 bg-colored"
             :slot-before="true">
  <bbn-button icon="nf nf-fa-plus"
              :text="_('Insert post')"
              :action="insertNote"/>
  <template v-slot:right>
    <span class="bbn-leftlabel"><?=_("Status")?></span>
    <bbn-dropdown :source="statusList"
                  class="bbn-right-space bbn-l"
                  v-model="currentStatus"
                  style="width: 10rem"/>
    <span class="bbn-leftlabel"><?=_("Categories")?></span>
    <bbn-dropdown :source="categories"
                  source-value="id"
                  class="bbn-right-space bbn-l bbn-wide"
                  v-model="cp.currentCategory"/>
    <bbn-input :nullable="true"
               button-right="nf nf-fa-search"
               class="bbn-wide bbn-l"
               v-model="searchValue"/>
  </template>
</bbn-toolbar>
