<div :class="componentClass">
	<bbn-form :source="{file: files}"
						:data="{
							ref: ref,
							id: source.id,
							action: isEdit ? 'edit' : 'insert',
							idGroup: idGroup ? idGroup : ''
						}"
						:prefilled="true"
						:action="url"
						@success="success"
						:scrollable="scrollable"
						:buttons="buttons">
		<div bbn-if="files.length && !isEdit"
				 class="bbn-vmiddle bbn-spadding"
				 style="justify-content: flex-end">
			<span><?= _('Customize titles/descriptions') ?></span>
			<bbn-switch bbn-model="showTitles"
									:value="true"
									:novalue="false"
									class="bbn-left-space"/>
		</div>
		<div class="bbn-grid-fields bbn-padding">
			<template bbn-for="(f, i) in files"
								bbn-if="showTitles || isEdit">
				<div><?= _('Filename') ?>:</div>
				<div bbn-text="f.name"></div>

        <div><?= _('Title') ?>:</div>
				<bbn-input bbn-model="f.title"/>

				<div bbn-if="isMediaGroup"><?= _('Link') ?>:</div>
				<bbn-input bbn-if="isMediaGroup" bbn-model="source.link"/>

        <div class="bbn-bottom-space"><?= _('Description') ?>:</div>
				<bbn-textarea bbn-model="f.description"
									 		class="bbn-bottom-space"/>

        <!--label><?= _("Tags") ?></label>
        <bbn-values bbn-model="source.tags"/-->
			</template>

      <div><?= _('Media') ?>:</div>
			<div>
				<bbn-upload :json="asJson"
										bbn-model="files"
										:paste="true"
										ref="upload"
										@success="onUploadSuccess"
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