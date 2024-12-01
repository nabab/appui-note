<!-- HTML Document -->

<div :class="componentClass">
  <div bbn-if="mode === 'edit'">
    <div class="bbn-padding">
      <div class="bbn-grid-fields">
        <!--label bbn-text="_('Columns (Desktop)')"></label>
        <bbn-grid-configuration :cols="5" :rows="1" @select="selectDesktopGrid"></bbn-grid-configuration>
        <label bbn-text="_('Columns (Mobile)')"></label>
        <bbn-grid-configuration @select="selectMobileGrid" :cols="5" :rows="1"></bbn-grid-configuration-->
        <label bbn-text="_('Image')"></label>
        <div class="appui-note-cms-block-image-preview">
          <div class="bbn-flex-width">
            <div class="bbn-block">
              <bbn-button icon="nf nf-fae-galery"
                          :notext="false"
                          @click="openGallery"
                          title="<?= _('Select an image') ?>"
                          class="bbn-right-sspace"/>
            </div>
            <div class="bbn-flex-fill">
              <img class="bbn-border bbn-radius"
                   :src="source.content"
                   style="max-width: 100%; height: auto"
                   bbn-if="!!source.content">
            </div>
          </div>
        </div>
        <label bbn-text="_('Width')"></label>
				<div>
          <bbn-range bbn-model="source.width"
                     :min="10"
                     :max="2000"
                     :step="10"
                     :show-reset="false"
                     :show-numeric="true"
                     :show-units="true"/>
          <bbn-button :class="['bbn-upper', 'bbn-w-100', 'bbn-s', 'bbn-top-sspace', {
                        'bbn-state-active': (source.width === 'auto') || (source.width === '') || (source.width === undefined)
                      }]"
                      @click="toggleAutoWidth"
                      :text="_('Auto')"/>
        </div>
				<label><?= _('Height') ?></label>
        <div>
          <bbn-range bbn-model="source.height"
                     :min="10"
                     :max="2000"
                     :step="10"
                     :show-reset="false"
                     :show-numeric="true"
                     :show-units="true"/>
          <bbn-button :class="['bbn-upper', 'bbn-w-100', 'bbn-s', 'bbn-top-sspace', {
                        'bbn-state-active': (source.height === 'auto') || (source.height === '') || (source.height === undefined)
                      }]"
                      @click="toggleAutoHeight"
                      :text="_('Auto')"/>
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
		<div class="bbn-flex image-text-container"
				 :style="{textAlign: source.align}">
			<a bbn-if="!!source.href"
				 target="_self"
				 :href="$parent.linkURL ? $parent.linkURL : '' + source.href"
				 class="bbn-c">
				<img :src="$parent.path + source.content"
			    	 :style="{
               width: source.width,
               height: source.height
             }"
						 :alt="source.alt ? source.alt : ''">
			</a>
			<div bbn-else-if="!!source.content">
				<img class="bbn-vsmargin"
             :style="{
               width: source.width,
               height: source.height
             }"
						 :src="source.content"
						 :alt="source.alt ? source.alt : ''">
			</div>
			<p class="image-caption bbn-s bbn-vsmargin"
				 bbn-if="!!source.caption"
				 bbn-html="source.caption"/>
			<!--error when using decodeuricomponent on details of home image-->
			<a bbn-if="!!source.href && !!source.details_title"
				 class="bbn-u"
				 target="_self"
				 :href="$parent.linkURL ? $parent.linkURL : '' + source.href">
				<h4 class="image-details-title bbn-w-100 bbn-vpadding bbn-no-margin"
						bbn-html="(source.details_title)"/>
			</a>
			<h4 class="image-details-title bbn-w-100 bbn-vpadding bbn-no-margin"
					bbn-else-if="!source.href && !!source.details_title"
					bbn-html="(source.details_title)"
				/>
			<p class="image-details bbn-vsmargin"
				 bbn-if="!!source.details"
				 bbn-html="source.details"/>
		</div>
  </div>
</div>
