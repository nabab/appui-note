<div class="appui-note-forum bbn-overlay bbn-background bbn-bordered">
	<div class="bbn-overlay bbn-flex-height">
		<div bbn-if="toolbar || search"
				 class="appui-note-forum-toolbar bbn-header bbn-flex-width bbn-no-border-top bbn-no-border-left bbn-no-border-right bbn-vmiddle"
				 ref="toolbar">
		  <!-- Toolbar -->
      <div bbn-if="toolbar"
           class="bbn-flex-fill">
        <div bbn-if="toolbarButtons.length"
             class="bbn-xspadded">
          <bbn-button bbn-for="(button, i) in toolbarButtons"
                      class="bbn-right-sspace"
                      :key="i"
                      bbn-bind="button"/>
        </div>
        <div bbn-else-if="typeof(toolbar) === 'function'"
             bbn-html="toolbar()"/>
        <component bbn-else
                   :is="toolbar"/>
      </div>
      <div bbn-if="search"
           class="bbn-spadded bbn-vmiddle">
        <span bbn-text="_('Rechercher')"
              class="bbn-right-sspace"/>
        <bbn-input bbn-model="filterString"
                   class="bbn-wide"
                   :button-right="filterString.length ? 'nf nf-fa-close' : 'nf nf-fa-search'"
                   :action-right="clearSearch"/>
      </div>
		</div>
		<!-- Main -->
		<div class="bbn-w-100 bbn-flex-fill">
			<bbn-scroll bbn-if="!isLoading && filteredData.length"
                  axis="y">
        <appui-note-forum-topic bbn-for="(d, i) in filteredData"
                                :key="d.key"
                                :source="d.data"
                                :index="d.index"
                                :class="{'bbn-bottom-spadded': !filteredData[i+1]}"/>
			</bbn-scroll>
		</div>
		<!-- Footer -->
    <bbn-pager :element="_self"
               class="appui-note-forum-pager bbn-no-border-top bbn-no-border-left bbn-no-border-right"/>
	</div>
</div>
