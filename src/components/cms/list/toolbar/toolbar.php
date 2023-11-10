<bbn-toolbar class="appui-note-cms-list-toolbar bbn-header bbn-spadded bbn-h-100 bg-colored"
             :slot-before="true">
  <bbn-button icon="nf nf-fa-plus"
              :text="_('Insert')"
              :action="insertNote"/>
  <div>
    <span :class="['bbn-leftlabel', {
            'bbn-disabled': groupActionsDisabled
          }]"
          v-text="_('Group actions')"/>
    <bbn-dropdown :source="groupActions"
                  :placeholder="_('Choose')"
                  class="bbn-l bbn-narrow"
                  :disabled="groupActionsDisabled"/>
  </div>
  <template v-slot:right>
    <div>
      <span class="bbn-leftlabel bbn-nowrap"
            v-text="_('Status')"/>
      <bbn-dropdown :source="statusList"
                    class="bbn-l"
                    v-model="currentStatus"
                    style="width: 10rem"/>
    </div>
    <div v-if="cp?.toolbarTypes">
      <span class="bbn-leftlabel bbn-nowrap"
            v-text="_('Categories')"/>
      <bbn-dropdown :source="categories"
                    source-value="id"
                    class="bbn-l bbn-wide"
                    v-model="cp.currentCategory"/>
    </div>
    <bbn-input :nullable="true"
               button-right="nf nf-fa-search"
               class="bbn-wide bbn-l"
               v-model="searchValue"/>
  </template>
</bbn-toolbar>
