<!-- HTML Document -->

<div :class="componentClass">
  <div bbn-if="mode === 'edit'">
    <div class="bbn-padded">
      <div class="bbn-grid-fields bbn-vspadded">
        <label bbn-text="_('Columns (Desktop)')"></label>
        <bbn-grid-configuration :cols="5" :rows="1" @select="selectDesktopGrid"></bbn-grid-configuration>
                                                                                                 
        
        <label bbn-text="_('Columns (Mobile)')"></label>
        <bbn-grid-configuration @select="selectMobileGrid" :cols="5" :rows="1"></bbn-grid-configuration>
        
        <label bbn-text="_('Image')"></label>
        <div class="appui-note-cms-block-image-preview bbn-flex">
          <bbn-button icon="nf nf-fae-galery"
										  :notext="false"
					 						@click="openGallery"
											title="<?= _('Select an image') ?>"
											class="bbn-right-sspace"/>
					<img class="bbn-bordered bbn-radius"
					 		 :src="source.source"
							 bbn-if="!!source.source">
        </div>
        <label bbn-text="_('Width')"></label>
				<bbn-range bbn-model="source.style.width"
									 :min="10"
									 :max="2000" 
									 :step="10"
									 :show-reset="false"
									 :show-numeric="true"
									 :show-units="true"/>
				<label><?= _('Height') ?></label>
				<bbn-range bbn-model="source.style.height"
									 :min="10"
									 :max="2000" 
									 :step="10"
									 :show-reset="false"
									 :show-numeric="true"
									 :show-units="true"/>
        <label bbn-text="_('Alignment')"></label>
        <div>
        	<div class="bbn-block">
          	<bbn-radiobuttons :notext="true"
                              bbn-model="source.align"
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
				<label bbn-text="_('Alt')"></label>
				<bbn-input bbn-model="source.alt"/>
				<label bbn-text="_('Link')"></label>
				<bbn-input bbn-model="source.href"/>
				<label bbn-text="_('Caption')"></label>
				<bbn-input bbn-model="source.caption"/>
				<label bbn-text="_('Details')"></label>
				<div>
					<div>
						<bbn-input bbn-model="source.details_title"
											 placeholder="<?= _('Title') ?>"
											 class="bbn-w-100"/>
					</div>
					<div>
						<bbn-input bbn-model="source.details"
											 placeholder="<?= _('Content') ?>"
											 class="bbn-w-100"/>
					</div>
				</div>
				
      </div> 
    </div>
  </div>          
  
  <div bbn-else>
		<div class="bbn-flex image-text-container"
				 :style="align">
			<a bbn-if="!!source.href"
				 target="_self"
				 :href="$parent.linkURL + source.href"
				 class="bbn-c">
				<img :src="$parent.path + source.source"
						 :alt="source.alt ? source.alt : ''">
			</a>
			<img bbn-else-if="!!source.source"
           class="bbn-vsmargin"
				 	 :src="source.source"
				 	 :alt="source.alt ? source.alt : ''">
			<p class="image-caption bbn-s bbn-vsmargin"
				 bbn-if="!!source.caption"
				 bbn-html="source.caption"/>
			<!--error when using decodeuricomponent on details of home image-->
			<p class="image-details-title bbn-vsmargin bbn-w-100 bbn-b"
				 bbn-if="!!source.details_title"
				 bbn-html="(source.details_title)"
				 />
			<p class="image-details bbn-vsmargin"
				 bbn-if="!!source.details"
				 bbn-html="source.details"/>
		</div>
  </div>
</div>
