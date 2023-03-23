<div class="appui-note-forum bbn-overlay bbn-background bbn-bordered">
	<div class="bbn-overlay bbn-flex-height">
		<div v-if="toolbar"
				 class="appui-note-forum-toolbar bbn-header bbn-w-100 bbn-no-border-top bbn-no-border-left bbn-no-border-right"
				 ref="toolbar"
				 style="min-height: 30px">
		  <!-- Toolbar -->
			<div v-if="toolbarButtons.length"
           class="bbn-">
				<bbn-button v-for="(button, i) in toolbarButtons"
										class="bbn-hsmargin"
										:key="i"
										v-bind="button"/>
			</div>
			<div v-else-if="typeof(toolbar) === 'function'"
					 v-html="toolbar()"/>
			<component v-else
								 :is="toolbar"/>
		</div>
		<!-- Main -->
		<div class="bbn-w-100 bbn-flex-fill">
			<bbn-scroll v-if="!isLoading">
      <appui-note-forum-topic v-for="(d, i) in currentData"
                              :key="i"
                              :source="d"
                              :index="i"/>
			</bbn-scroll>
		</div>
		<!-- Footer -->
		<div class="appui-note-forum-pager bbn-widget bbn-no-border-bottom bbn-no-border-left bbn-no-border-right"
         v-if="pageable || filterable || isAjax">
      <div class="bbn-block"
           v-if="pageable">
        <bbn-button icon="nf nf-fa-angle_double_left"
                    :notext="true"
                    title="<?=_('Go to the first page')?>"
                    :disabled="isLoading || (currentPage == 1)"
                    @click="currentPage = 1"/>
        <bbn-button icon="nf nf-fa-angle_left"
                    :notext="true"
                    title="<?=_('Go to the previous page')?>"
                    :disabled="isLoading || (currentPage == 1)"
                    @click="currentPage--"/>
        <span><?=_('Page')?></span>
        <bbn-numeric v-if="currentData.length"
                     v-model="currentPage"
                     :min="1"
                     :max="numPages"
                     :disabled="isLoading"
                     class="bbn-narrower bbn-right-sspace"/>
        <span v-text="'<?=_('of')?> ' + numPages" style="margin-right: 0.25em"></span>
        <bbn-button icon="nf nf-fa-angle_right"
                    :notext="true"
                    title="<?=_('Go to the next page')?>"
                    :disabled="isLoading || (currentPage == numPages)"
                    @click="currentPage++"/>
        <bbn-button icon="nf nf-fa-angle_double_right"
                    :notext="true"
                    title="<?=_('Go to the last page')?>"
                    @click="currentPage = numPages"
                    :disabled="isLoading || (currentPage == numPages)"/>
        <span class="bbn-hmargin">
          <bbn-dropdown :source="limits"
                        v-model.number="currentLimit"
                        @change="currentPage = 1"
                        :disabled="!!isLoading"
                        :autosize="true"/>
          <span><?=_('items per page')?></span>
        </span>
      </div>
      <div class="bbn-block" style="float: right">
        <span v-if="pageable"
              v-text="'<?=_('Display items')?> ' + (start+1) + '-' + (start + currentLimit > total ? total : start + currentLimit) + ' <?=_('of')?> ' + total"/>
        <span v-else
              v-text="total ? '<?=_('Total')?> : ' + total + ' <?=_('items')?>' : '<?=_('No item')?>'"/>
        &nbsp;
        <bbn-button v-if="isAjax"
                    title="<?=_('Refresh')?>"
                    @click="updateData"
                    icon="nf nf-fa-refresh"/>
      </div>
    </div>
	</div>
</div>
