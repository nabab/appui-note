<!-- HTML Document -->

<div :class="componentClass">
	<bbn-form :source="{file: files}"
						:data="{
							ref: ref,
							id: source.id,
							action: isEdit ? 'edit' : 'insert'
						}"
						:action="url"
						@success="success"
						:scrollable="scrollable"
						:buttons="buttons">
		<div v-if="files.length && !isEdit"
				 class="bbn-vmiddle bbn-bottom-space"
				 style="justify-content: flex-end">
			<span><?= _('Customize titles/descriptions') ?></span>
			<bbn-switch v-model="showTitles"
									:value="true"
									:novalue="false"
									class="bbn-left-space"/>
		</div>
		<div class="bbn-grid-fields bbn-padded">
			<template v-for="(f, i) in files"
								v-if="showTitles || isEdit">
				<div><?= _('Filename') ?>:</div>
				<div v-text="f.name"></div>

        <div><?= _('Title') ?>:</div>
				<bbn-input v-model="f.title"/>

        <div class="bbn-bottom-space"><?= _('Description') ?>:</div>
				<bbn-textarea v-model="f.description"
									 		class="bbn-bottom-space"/>

        <!--label><?= _("Tags") ?></label>
        <bbn-values v-model="source.tags"/-->
			</template>

      <div><?= _('Media') ?>:</div>
			<div>
				<bbn-upload :json="asJson"
										v-model="files"
										:paste="true"
										:multiple="!isEdit"
										:save-url="root + 'media/actions/upload_save/' + ref"
										@beforeRemove="onRemove"
										:remove-url="root + 'media/actions/delete_file/'+ ref"
										:data="{
											ref: ref,
											id: source.id
										}"/>
			</div>
		</div>
	</bbn-form>
</div>