<div class="appui-note-widget-news"
       style="min-height: 150px">
  <div bbn-if="showForm">
    <bbn-form :buttons="[]"
              :fixedFooter="false"
              :source="formData"
              ref="form"
							:scrollable="false"
              :validation="validForm"
              :action="notesRoot + '/actions/insert'"
              @success="afterSubmit">
      <div class="bbn-grid-fields"
           style="margin-bottom: 10px; padding: 0">
        <div><?= _('Title') ?></div>
        <bbn-input bbn-model="formData.title"
                   required="required"/>
        <div><?= _("Pub. date") ?></div>
        <bbn-datetimepicker bbn-model="formData.start"
                            required="required"/>
        <div><?= _("End date") ?></div>
        <bbn-datetimepicker bbn-model="formData.end"/>
        <!--div><?= _("For who") ?></div>
        <bbn-dropdown bbn-model="destinataries"
                      :source="[{value: 'all', text: _('All')}, {value: 'group', text: _('My group %s', appui.userGroup.nom)}]"
                      :required="true"/>
        <div class="bbn-c"
           style="margin-bottom: 10px">
          <bbn-checkbox bbn-model="formData.private"
                        value="1"
                        novalue="0"
                        label="<i class='nf nf-fa-eye_slash'></i> <?/*=_('Private')*/?>"
                        style="margin-right: 2em"/>
          <bbn-checkbox bbn-model="formData.locked"
                        value="1"
                        novalue="0"
                        label="<i class='nf nf-fa-lock'></i>  <?/*=_('Locked')*/?>"/>
          </div>-->
        <div class="bbn-grid-full" style="width: 100%; height: 400px">
					<bbn-rte bbn-model="formData.content"
	                 required="required"
									 height="100%"/>
        </div>
        <div class="bbn-grid-full bbn-r">
          <bbn-button @click="$refs.form.submit()"
                      icon="nf nf-fa-save">
            <?= _('Add') ?>
          </bbn-button>
          <bbn-button @click="closeForm"
                      icon="nf nf-fa-times">
            <?= _('Cancel') ?>
          </bbn-button>
        </div>
      </div>
    </bbn-form>
  </div>
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
       class="bbn-middle">
    <div class="bbn-block bbn-m bbn-i bbn-c">
      <?= _("Here you can add") ?><br>
      <?= _("news or internal com") ?><br>
      <?= _("for all users") ?>
    </div>
  </div>
</div>
