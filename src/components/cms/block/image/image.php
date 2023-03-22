<!-- HTML Document -->

<div :class="componentClass">
  <div v-if="mode === 'edit'">
    <div class="bbn-padded">
      <div class="bbn-grid-fields">
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
		<div class="bbn-flex"
				 :style="align">
			<a v-if="!!currentSource.href"
         :style="{'width': currentSource.width, 'height': currentSource.height}"
				 target="_self"
				 :href="$parent.linkURL ? $parent.linkURL + currentSource.href : currentSource.href"
				 class="bbn-c">
				<img :src="$parent.path + currentSource.content"
						 :alt="currentSource.alt ? currentSource.alt : ''">
			</a>
			<img v-else-if="!!currentSource.content"
           :style="{'width': currentSource.width, 'height': currentSource.height}"
				 	 :src="currentSource.content"
				 	 :alt="currentSource.alt ? currentSource.alt : ''">
			<p class="image-caption bbn-l bbn-s bbn-vsmargin"
				 v-if="!!currentSource.caption"
				 v-html="currentSource.caption"/>
			<!--error when using decodeuricomponent on details of home image-->
			<a class="image-details-title bbn-l bbn-vsmargin bbn-w-100"
				 v-if="!!currentSource.details_title"
				 v-html="(currentSource.details_title)"
				 :href="currentSource.href"
				 target="_blank"/>
			<p class="image-details bbn-l bbn-vsmargin"
				 v-if="!!currentSource.details"
				 v-html="currentSource.details"/>
		</div>
  </div>
</div>
