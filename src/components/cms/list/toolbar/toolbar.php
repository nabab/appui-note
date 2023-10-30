<bbn-toolbar class="appui-note-cms-list-toolbar bbn-header bbn-hspadded bbn-h-100 bg-colored"
             :slot-before="true">
  <bbn-button icon="nf nf-fa-plus"
              :text="_('Insert')"
              :action="insertNote"
              class="bbn-right-space"/>
  <span :class="['bbn-leftlabel', {
          'bbn-disabled': groupActionsDisabled
        }]"
        v-text="_('Group actions')"/>
  <bbn-dropdown :source="groupActions"
                :placeholder="_('Choose')"
                class="bbn-right-space bbn-l bbn-narrow"
                :disabled="groupActionsDisabled"/>
  <template v-slot:right>
    <span class="bbn-leftlabel"
          v-text="_('Status')"/>
    <bbn-dropdown :source="statusList"
                  class="bbn-right-space bbn-l"
                  v-model="currentStatus"
                  style="width: 10rem"/>
    <template v-if="cp?.toolbarTypes">
      <span class="bbn-leftlabel"
            v-text="_('Categories')"/>
      <bbn-dropdown :source="categories"
                    source-value="id"
                    class="bbn-right-space bbn-l bbn-wide"
                    v-model="cp.currentCategory"/>
    </template>
    <bbn-input :nullable="true"
               button-right="nf nf-fa-search"
               class="bbn-wide bbn-l"
               v-model="searchValue"/>
  </template>
</bbn-toolbar>
