<!-- HTML Document -->

<div :class="componentClass">
  <div v-if="mode === 'edit'"
       class="bbn-w-100">
    <div class="bbn-padded bbn-w-100">
      <div class="bbn-grid-fields">
        <label v-text="_('Image')"></label>
        <div class="appui-note-cms-block-image-preview bbn-flex">
          <bbn-button icon="nf nf-fae-galery"
										  :notext="true"
					 						@click="openGallery"
											title="<?=_('Select an image')?>"
											class="bbn-right-sspace"/>
					<img class="bbn-bordered bbn-radius"
					 		 :src="source.content"
							 v-if="!!source.content">
        </div>
        <label v-text="_('Width')"></label>
        <div>
          <bbn-range v-model="source.width"
                     :show-reset="false"
                     :show-numeric="true"
                     :show-units="true"
                     ref="widthRange"
                     :disabled="(source.width === 'auto') || (source.width === '') || (source.width === undefined)"/>
          <bbn-button :class="['bbn-upper', 'bbn-w-100', 'bbn-s', 'bbn-top-sspace', {
                        'bbn-state-active': (source.width === 'auto') || (source.width === '') || (source.width === undefined)
                      }]"
                      @click="toggleAutoWidth"
                      :text="_('Auto')"/>
        </div>
				<label><?=_('Height')?></label>
        <div>
          <bbn-range v-model="source.height"
                     :show-reset="false"
                     :show-numeric="true"
                     :show-units="true"
                     ref="heightRange"
                     :disabled="(source.height === 'auto') || (source.height === '') || (source.height === undefined)"/>
          <bbn-button :class="['bbn-upper', 'bbn-w-100', 'bbn-s', 'bbn-top-sspace', {
                        'bbn-state-active': (source.height === 'auto') || (source.height === '') || (source.height === undefined)
                      }]"
                      @click="toggleAutoHeight"
                      :text="_('Auto')"/>
        </div>
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
  <div v-else>
		<div class="bbn-flex"
				 :style="align">
      <div v-if="$parent.selectable && !source.content"
           class="bbn-alt-background bbn-middle bbn-lpadded bbn-w-100"
           style="overflow: hidden">
        <i class="bbn-xxxxl nf nf-fa-image"/>
      </div>
			<a v-if="!!source.href && !!source.content"
         :style="{width: source.width, height: source.height}"
				 target="_self"
				 :href="$parent.linkURL ? $parent.linkURL + source.href : source.href"
				 class="bbn-c">
				<img :src="$parent.path + source.content"
						 :alt="source.alt ? source.alt : ''">
			</a>
			<img v-else-if="!!source.content"
           :style="{'width': source.width, 'height': source.height}"
				 	 :src="source.content"
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
