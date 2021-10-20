<!-- HTML Document -->

<div :class="[componentClass, 'bbn-padded']">
	<bbn-form :validation="validation"
						:source="source"
						:data="{ref:ref, id_note:id_note}"
						:action="root + (source.edit ? 'media/actions/edit' : 'media/actions/save')"
						@success="success">
		<div class="bbn-grid-fields">
			<div v-if="browser.single"><?=_('Title')?>:</div>
			<bbn-input v-model="source.media.title"
								 @blur="checkTitle"
                 v-if="browser.single" 
                 :disabled="source.edit ? false : (!source.media.file.length ?true : false )"/>
			<div v-if="browser.single"><?=_('Filename')?>:</div>
			<bbn-input v-if="browser.single"
                 v-model="source.media.name"
								 :disabled="source.edit ? false : (!source.media.file.length ?true : false )"/>
			<div><?=_('Media')?>:</div>
			<div>
				<bbn-upload v-if="source.edit"
										:json="true"
										v-model="content"
										:paste="true"
										:multiple="false"
										:save-url="root + 'media/actions/upload_save/' + ref"
										@remove="setRemovedFile"
										:remove-url="root + 'media/actions/delete_file/'+ source.media.id"/>
				<bbn-upload v-model="source.media.file"
										v-else
									  @success="uploadSuccess"
										:paste="true"
										:multi="false"
										:save-url="root + 'media/actions/upload_save/' + ref"/>
			</div>
		</div>
	</bbn-form>
</div>