<!-- HTML Document -->

<div :class="componentClass">
  <div v-if="mode === 'edit'">
    <div class="bbn-padded">
      <div class="bbn-grid-fields bbn-vspadded">
        <label v-text="_('Image')"></label>
        <div class="appui-note-cms-block-image-preview bbn-flex">
          <bbn-button icon="nf nf-fae-galery"
										  :notext="false"
					 						@click="openGallery"
											title="<?=_('Select an image')?>"
											class="bbn-right-sspace"/>
					<img class="bbn-bordered bbn-radius"
					 		 :src="source.source"
							 v-if="!!source.source">
        </div>
        <label v-text="_('Width')"></label>
				<bbn-range v-model="source.style.width"
									 :min="10"
									 :max="2000" 
									 :step="10"
									 :show-reset="false"
									 :show-label="true"
									 :show-units="true"/>
				<label><?=_('Height')?></label>
				<bbn-range v-model="source.style.height"
									 :min="10"
									 :max="2000" 
									 :step="10"
									 :show-reset="false"
									 :show-label="true"
									 :show-units="true"/>
        <label v-text="_('Alignment')"></label>
        <div>
        	<div class="bbn-block">
          	<bbn-radiobuttons :notext="true"
                              v-model="source.align"
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
				<bbn-input v-model="source.alt"/>
				<label v-text="_('Link')"></label>
				<bbn-input v-model="source.href"/>
				<label v-text="_('Caption')"></label>
				<bbn-input v-model="source.caption"/>
				<label v-text="_('Details')"></label>
				<div>
					<div>
						<bbn-input v-model="source.details_title"
											 placeholder="<?=_('Title')?>"
											 class="bbn-w-100"/>
					</div>
					<div>
						<bbn-input v-model="source.details"
											 placeholder="<?=_('Content')?>"
											 class="bbn-w-100"/>
					</div>
				</div>
				
      </div> 
    </div>
  </div>          
  <div v-else
			 class="bbn-flex"
       :style="align">
		<div class="bbn-block"
				 :style="source.style">
			<a v-if="!!source.href"
				 target="_self"
				 :href="$parent.linkURL + source.href"
				 class="bbn-c">
				<img :src="$parent.path + source.source"
						 :alt="source.alt ? source.alt : ''">
			</a>
			<img v-else-if="!!source.source"
				 	 :src="source.source"
				 	 :alt="source.alt ? source.alt : ''">
			<p class="image-caption bbn-l bbn-s bbn-vsmargin"
				 v-if="!!source.caption"
				 v-html="source.caption"/>
			<!--error when using decodeuricomponent on details of home image-->
			<a class="image-details-title bbn-l bbn-vsmargin bbn-w-100"
				 v-if="!!source.details_title"
				 v-html="(source.details_title)"
				 :href="source.href"
				 target="_blank"/>
			<p class="image-details bbn-l bbn-vsmargin"
				 v-if="!!source.details"
				 v-html="source.details"/>
		</div>
  </div>
</div>
