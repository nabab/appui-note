<div class="appui-note-forum bbn-overlay bbn-background bbn-bordered">
	<div class="bbn-overlay bbn-flex-height">
		<div v-if="toolbar"
				 class="appui-note-forum-toolbar bbn-header bbn-w-100 bbn-no-border-top bbn-no-border-left bbn-no-border-right"
				 ref="toolbar">
		  <!-- Toolbar -->
			<div v-if="toolbarButtons.length"
           class="bbn-xspadded">
				<bbn-button v-for="(button, i) in toolbarButtons"
										class="bbn-right-sspace"
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
			<bbn-scroll v-if="!isLoading"
                  axis="y">
      <appui-note-forum-topic v-for="(d, i) in filteredData"
                              :key="d.key"
                              :source="d.data"
                              :index="d.index"
                              :class="{'bbn-bottom-spadded': !filteredData[i+1]}"/>
			</bbn-scroll>
		</div>
		<!-- Footer -->
    <bbn-pager :element="_self"
               class="bbn-no-border bbn-radius"/>
	</div>
</div>
