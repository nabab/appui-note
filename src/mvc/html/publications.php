<div class="bbn-flex-height appui-note-publications">
  <bbn-toolbar>
    <div class="bbn-flex-width bbn-w-100">
      <div>
        <bbn-menu class="bbn-h-100"
                  ref="menu"
                  :source="sourceMenu"
        ></bbn-menu>
      </div>
      <div class="bbn-hpadding bbn-vspadding bbn-xl bbn-b bbn-flex-fill bbn-c">
        <?= _("Publications' management") ?>
      </div>
    </div>
  </bbn-toolbar>
  <div class="bbn-flex-fill">
    <bbn-table class="bbn-w-100"
              ref="table"
              :source="root + 'publications'"
              :columns="cols"
              :limit="25"
              :info="true"
              :pageable="true"
              :sortable="true"
              :filterable="true"              
    ></bbn-table>
  </div>
</div>

<!--form for create new pge in note-->
<script type="text/x-template" id="appui-note-new-page">
  <bbn-form ref="form"
            :action="root + '/actions/publications/insert'"
            :source="formData"              
            :scrollable="false"
            :validation="validationForm"  
            @success="afterSubmit"    
  >
    <div class="bbn-overlay bbn-flex-height">        
      <div class="bbn-grid-fields bbn-lpadding">
        <label class="bbn-b">
          <?= _('Title') ?>
        </label>
        <bbn-input bbn-model="formData.title"
                  required="required"
                  class="bbn-w-50"
        ></bbn-input>
        <label class="bbn-b">
          <?= _('Pub. date') ?>
        </label>
        <bbn-datetimepicker bbn-model="formData.start"
                            required="required"
                            class="bbn-w-20"
        ></bbn-datetimepicker>
        <label class="bbn-b" bbn-text="_('End date') + ':'"></label>
        <bbn-datetimepicker bbn-model="formData.end"
                            class="bbn-w-20"
        ></bbn-datetimepicker>

        <label class="bbn-b" bbn-text="_('Url') + ':'"></label>
        <bbn-input bbn-model="formData.url"
                   required="required"
                   class="bbn-w-100"
        ></bbn-input>
      </div>
      <div class="bbn-flex-fill bbn-lpadding">
        <bbn-rte bbn-model="formData.content"
                required="required"
                height="100%"                  
        ></bbn-rte>
      </div>
    </div>        
  </bbn-form>
</script>

<!--form for create new page in note-->
<script type="text/x-template" id="appui-note-import-page">
  <div class="bbn-flex-height">
    <div class="bbn-flex-fill">
      <bbn-table ref="table"
                :source="root + 'pages/wordpress'"
                :columns="colsTable"    
                :scrollable="true"   
                :limit="10"            
                :info="true"
                :selection="true"
                :pageable="true"
                :sortable="true"
                :filterable="true"
                class="bbn-100"
                @select="selectPost"
                @unselect="unselectPost"
      ></bbn-table>
    </div>
    <div>
      <div class="bbn-w-100 bbn-flex-width">
        <div class="bbn-w-50">
          <bbn-button class="bbn-w-100"          
							        :label="_('Cancel')"							      
							        icon="nf nf-fa-times_circle"
                      @click="closePopUp"
          ></bbn-button>
        </div> 
        <div class="bbn-flex-fill">
          <bbn-button class="bbn-w-100"          
							        :label="_('Import')"							      
							        icon="nf nf-md-import"
                      @click="importPage"
                      :disabled="!selected"
          ></bbn-button>
        </div> 
      </div>
    </div>
  </div>
</script>