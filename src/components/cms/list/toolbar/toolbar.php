<bbn-toolbar class="appui-note-cms-list-toolbar bbn-header bbn-spadding bbn-h-100 bg-colored"
             :slot-before="true">
  <bbn-button icon="nf nf-fa-plus"
              :label="_('Insert')"
              :action="insertNote"/>
  <div class="bbn-flex">
    <span :class="['bbn-leftlabel', {
            'bbn-disabled': groupActionsDisabled
          }]"
          bbn-text="_('Group actions')"/>
    <bbn-dropdown :source="groupActions"
                  :placeholder="_('Choose')"
                  class="bbn-l bbn-narrow"
                  :disabled="groupActionsDisabled"/>
  </div>
  <template bbn-slot:right>
    <div class="bbn-flex">
      <span class="bbn-leftlabel bbn-nowrap"
            bbn-text="_('Status')"/>
      <bbn-dropdown :source="statusList"
                    class="bbn-l"
                    bbn-model="currentStatus"
                    style="width: 10rem"/>
    </div>
    <div bbn-if="cp?.toolbarTypes"
         class="bbn-flex">
      <span class="bbn-leftlabel bbn-nowrap"
            bbn-text="_('Categories')"/>
      <bbn-dropdown :source="categories"
                    source-value="id"
                    class="bbn-l bbn-wide"
                    bbn-model="currentCategory"/>
    </div>
    <bbn-input :nullable="true"
               button-right="nf nf-fa-search"
               class="bbn-wide bbn-l"
               bbn-model="searchValue"/>
  </template>
</bbn-toolbar>
