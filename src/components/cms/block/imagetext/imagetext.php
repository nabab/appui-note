<!-- HTML Document -->

<div :class="componentClass">
  <div v-if="mode === 'edit'">
    <div class="bbn-padded">
      <div class="bbn-grid-fields">
        <!--label v-text="_('Columns (Desktop)')"></label>
        <bbn-grid-configuration :cols="5" :rows="1" @select="selectDesktopGrid"></bbn-grid-configuration>
        <label v-text="_('Columns (Mobile)')"></label>
        <bbn-grid-configuration @select="selectMobileGrid" :cols="5" :rows="1"></bbn-grid-configuration-->
        <label v-text="_('Image')"></label>
        <div class="appui-note-cms-block-image-preview bbn-flex">
          <bbn-button icon="nf nf-fae-galery"
										  :notext="false"
					 						@click="openGallery"
											title="<?=_('Select an image')?>"
											class="bbn-right-sspace"/>
					<img class="bbn-bordered bbn-radius"
					 		 :src="currentSource.content"
							 v-if="!!currentSource.content">
        </div>
        <label v-text="_('Width')"></label>
				<bbn-range v-model="currentSource.width"
									 :min="10"
									 :max="2000"
									 :step="10"
									 :show-reset="false"
									 :show-numeric="true"
									 :show-units="true"/>
				<label><?=_('Height')?></label>
				<bbn-range v-model="currentSource.height"
									 :min="10"
									 :max="2000"
									 :step="10"
									 :show-reset="false"
									 :show-numeric="true"
									 :show-units="true"/>
        <label v-text="_('Alignment')"></label>
        <div>
        	<div class="bbn-block">
          	<bbn-radiobuttons :notext="true"
                              v-model="currentSource.align"
                              :source="[{
                                 text: _('Align left'),
                                 value: 'left',
                                 icon: 'nf nf-fa-align_left'
                              }, {
                                 text: _('Align center'),
                                 value: 'center',
                                 icon: 'nf nf-fa-align_center'
                              }, {
                                 text: _('Align right'),
                                 value: 'right',
                                 icon: 'nf nf-fa-align_right'
                              }]"/>
					</div>
        </div>
				<label v-text="_('Alt')"></label>
				<bbn-input v-model="currentSource.alt"/>
				<label v-text="_('Link')"></label>
				<bbn-input v-model="currentSource.href"/>
				<label v-text="_('Caption')"></label>
				<bbn-input v-model="currentSource.caption"/>
				<label v-text="_('Details')"></label>
				<div>
					<div>
						<bbn-input v-model="currentSource.details_title"
											 placeholder="<?=_('Title')?>"
											 class="bbn-w-100"/>
					</div>
					<div>
						<bbn-input v-model="currentSource.details"
											 placeholder="<?=_('Content')?>"
											 class="bbn-w-100"/>
					</div>
				</div>
      </div>
    </div>
  </div>
  <div v-else>
		<div class="bbn-flex image-text-container"
				 :style="align">
			<a v-if="!!currentSource.href"
				 target="_self"
				 :href="$parent.linkURL ? $parent.linkURL : '' + currentSource.href"
				 class="bbn-c">
				<img :src="$parent.path + currentSource.content"
			    	 :style="currentStyle"
						 :alt="currentSource.alt ? currentSource.alt : ''">
			</a>
			<div v-else-if="!!currentSource.content">
				<img class="bbn-vsmargin"
						 :style="currentStyle"
						 :src="currentSource.content"
						 :alt="currentSource.alt ? currentSource.alt : ''">
			</div>
			<p class="image-caption bbn-s bbn-vsmargin"
				 v-if="!!currentSource.caption"
				 v-html="currentSource.caption"/>
			<!--error when using decodeuricomponent on details of home image-->
			<a v-if="!!currentSource.href && !!currentSource.details_title"
				 class="bbn-u"
				 target="_self"
				 :href="$parent.linkURL ? $parent.linkURL : '' + currentSource.href">
				<h4 class="image-details-title bbn-w-100 bbn-vpadded bbn-no-margin"
						v-html="(currentSource.details_title)"/>
			</a>
			<h4 class="image-details-title bbn-w-100 bbn-vpadded bbn-no-margin"
					v-else-if="!currentSource.href && !!currentSource.details_title"
					v-html="(currentSource.details_title)"
				/>
			<p class="image-details bbn-vsmargin"
				 v-if="!!currentSource.details"
				 v-html="currentSource.details"/>
		</div>
  </div>
</div>
