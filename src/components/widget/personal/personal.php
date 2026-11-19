<div class="appui-note-widget-personal">
  <div bbn-if="showForm">
    <bbn-form style="height: 500px"
              :buttons="[]"
              :fixedFooter="false"
              :source="formData"
              ref="form"
							:scrollable="false"
              action="notes/actions/insert"
              @success="afterSubmit">
      <bbn-input bbn-model="formData.title"
                 placeholder="<?= _('Title') ?>"
                 class="bbn-bottom-sspace bbn-w-100"/>
      <!--<div class="bbn-c"
           style="margin-bottom: 10px"
      >
        <bbn-checkbox bbn-model="formData.postit"
                      value="1"
                      novalue="0"
                      label="<i class='nf nf-fa-eye_slash'></i> <?/*=_('Post-it')*/?>"
        ></bbn-checkbox>
      </div>-->
      <div class="bbn-w-100"
           style="height: 400px">
					<bbn-rte bbn-model="formData.content"
	                 required="required"
									 height="100%"/>
      </div>
      <div class="bbn-w-100 bbn-r bbn-top-spadding">
        <bbn-button class="bbn-right-sspace"
                    @click="$refs.form.submit()"
										icon="nf nf-fa-save"
                    :label="_('Add')"/>
        <bbn-button @click="closeForm"
										icon="nf nf-fa-times"
                    :label="_('Cancel')"/>
      </div>
    </bbn-form>
  </div>
  <template bbn-else>
    <bbn-list :source="source"
              :component="$options.components.item"
              @select="openNote"
              :pageable="true"
              ref="list"
              :data="currentPostData"
              :limit="currentLimit"
              :limits="[]"
              @hook:mounted="onListMounted"/>
    <div bbn-if="isPagerVisible && hasListData"
          class="bbn-bottom-lpadding"/>
    <bbn-pager bbn-if="isPagerVisible && hasListData"
                :element="$refs.list"
                class="bbn-bottom-left bbn-bottom-radius bbn-no-border"/>
    <div bbn-if="!hasListData"
         class="bbn-middle"
         bbn-text="_('No data') + '...'"/>
  </template>
</div>
