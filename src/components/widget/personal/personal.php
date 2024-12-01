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
                 style="margin-bottom: 10px; width: 100%"/>
      <!--<div class="bbn-c"
           style="margin-bottom: 10px"
      >
        <bbn-checkbox bbn-model="formData.postit"
                      value="1"
                      novalue="0"
                      label="<i class='nf nf-fa-eye_slash'></i> <?/*=_('Post-it')*/?>"
        ></bbn-checkbox>
      </div>-->
      <div class="bbn-w-100" style="width: 100%; height: 400px">
					<bbn-rte bbn-model="formData.content"
	                 required="required"
									 height="100%"/>
      </div>
      <div class="bbn-w-100 bbn-r"
					 style="margin-top: 20px">
        <bbn-button style="margin-right:0.5em"
                    @click="$refs.form.submit()"
										icon="nf nf-fa-save"
        ><?= _('Add') ?></bbn-button>
        <bbn-button @click="closeForm"
										icon="nf nf-fa-times"
				><?= _('Cancel') ?></bbn-button>
      </div>

    </bbn-form>
  </div>
  <div bbn-else class="bbn-padding">
    <ul class="bbn-no-padding bbn-no-margin"
        bbn-if="source?.items">
      <div bbn-for="item in source.items"
           style="padding: 0.4em 0.6em"
           class="bbn-vmiddle">
        <bbn-initial width="20"
                     height="20"
                     :user-id="item.id_user"
                     :user-name="userName(item.id_user)"/>
        <span bbn-if="shorten(item.title, 50)"
              bbn-text="item.title"
              title="item.title"
              @click="openNote(item)"
              class="bbn-p"
              style="margin-left: 5px"/>
        <span bbn-else
              bbn-text="html2text(shorten(item.content, 50))"
              @click="openNote(item)"
              class="bbn-p"
              style="margin-left: 5px"/>
      </div>
    </ul>
  </div>
</div>
