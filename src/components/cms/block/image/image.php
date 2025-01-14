<!-- HTML Document -->

<div :class="componentClass">
  <div bbn-if="mode === 'edit'"
       class="bbn-w-100">
    <div class="bbn-padding bbn-w-100">
      <div class="bbn-grid-fields">
        <label bbn-text="_('Image')"></label>
        <div class="appui-note-cms-block-image-preview bbn-flex">
          <bbn-button icon="nf nf-fae-galery"
										  :notext="true"
					 						@click="openGallery"
											title="<?= _('Select an image') ?>"
											class="bbn-right-sspace"/>
					<img class="bbn-border bbn-radius"
					 		 :src="source.content"
							 bbn-if="!!source.content">
        </div>
        <label bbn-text="_('Width')"></label>
        <div>
          <bbn-range bbn-model="source.width"
                     :show-reset="false"
                     :show-numeric="true"
                     :show-units="true"
                     ref="widthRange"
                     :disabled="(source.width === 'auto') || (source.width === '') || (source.width === undefined)"/>
          <bbn-button :class="['bbn-upper', 'bbn-w-100', 'bbn-s', 'bbn-top-sspace', {
                        'bbn-state-active': (source.width === 'auto') || (source.width === '') || (source.width === undefined)
                      }]"
                      @click="toggleAutoWidth"
                      :label="_('Auto')"/>
        </div>
				<label><?= _('Height') ?></label>
        <div>
          <bbn-range bbn-model="source.height"
                     :show-reset="false"
                     :show-numeric="true"
                     :show-units="true"
                     ref="heightRange"
                     :disabled="(source.height === 'auto') || (source.height === '') || (source.height === undefined)"/>
          <bbn-button :class="['bbn-upper', 'bbn-w-100', 'bbn-s', 'bbn-top-sspace', {
                        'bbn-state-active': (source.height === 'auto') || (source.height === '') || (source.height === undefined)
                      }]"
                      @click="toggleAutoHeight"
                      :label="_('Auto')"/>
        </div>
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
		<div class="bbn-flex"
				 :style="align">
      <div bbn-if="$parent.selectable && !source.content"
           class="bbn-alt-background bbn-middle bbn-lpadding bbn-w-100"
           style="overflow: hidden">
        <i class="bbn-xxxxl nf nf-fa-image"/>
      </div>
			<a bbn-if="!!source.href && !!source.content"
         :style="{width: source.width, height: source.height}"
				 target="_self"
				 :href="$parent.linkURL ? $parent.linkURL + source.href : source.href"
				 class="bbn-c">
				<img :src="$parent.path + source.content"
						 :alt="source.alt ? source.alt : ''">
			</a>
			<img bbn-else-if="!!source.content"
           :style="{'width': source.width, 'height': source.height}"
				 	 :src="source.content"
				 	 :alt="source.alt ? source.alt : ''">
			<p class="image-caption bbn-l bbn-s bbn-vsmargin"
				 bbn-if="!!source.caption"
				 bbn-html="source.caption"/>
			<!--error when using decodeuricomponent on details of home image-->
			<a class="image-details-title bbn-l bbn-vsmargin bbn-w-100"
				 bbn-if="!!source.details_title"
				 bbn-html="(source.details_title)"
				 :href="source.href"
				 target="_blank"/>
			<p class="image-details bbn-l bbn-vsmargin"
				 bbn-if="!!source.details"
				 bbn-html="source.details"/>
		</div>
  </div>
</div>
