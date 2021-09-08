<!-- HTML Document -->

<div :class="[componentClass, 'bbn-padded']">
	<bbn-form :validation="validation" :source="source" :data="{ref:ref, id_note:id_note}" :action="root + (source.edit ? 'media/actions/edit' : 'media/actions/save')" @success="success">
		<div class="bbn-grid-fields">
			<div v-if="browser.single">Title: </div>
			<bbn-input v-model="source.media.title" @blur="checkTitle"
                 v-if="browser.single" 
                 :disabled="source.edit ? false : (!source.media.file.length ?true : false )"
			></bbn-input>

			<div v-if="browser.single">Filename: </div>
			<bbn-input v-if="browser.single"
                 v-model="source.media.name"
								 :disabled="source.edit ? false : (!source.media.file.length ?true : false )"
			></bbn-input>

			<div>Media: </div>
			<div>
				<bbn-upload v-if="source.edit"
										:json="true"
										v-model="content"
										:paste="true"
										:multiple="false"
										:save-url="root + 'media/actions/upload_save/' + ref"
										@remove="setRemovedFile"
										:remove-url="root + 'media/actions/delete_file/'+ source.media.id"
				></bbn-upload>
				<bbn-upload v-model="source.media.file"
										v-else
									  @success="uploadSuccess"
										:paste="true"
										:multi="false"
										:save-url="root + 'media/actions/upload_save/' + ref"
				></bbn-upload></div>
		</div>
	</bbn-form>
</div>