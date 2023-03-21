
<div :class="[componentClass, 'bbn-flex-height', 'bbn-background', {'bbn-overlay': !!scrollable}]"
     ref="browser">
  <bbn-gallery :source="source"
               :source-action="sourceAction"
               :search-name="searchName"
               :pageable="pageable"
               :filterable="filterable"
               :limit="limit"
               :zoomable="zoomable"
               :info="info"
               :path-name="pathName"
               :overlay-name="overlayName"
               :overlay="overlay"
               :toolbar="true"
               :toolbar-buttons="toolbarButtons"
               :uploadable="uploadEnabled"
               :downloadable="downloadEnabled"
               :deletable="removeEnabled"
               @upload="addMedia"
               @download="downloadMedia"
               @delete="removeMedia"
               @selection="selectMedia"
               @clickItem="emitClickItem"
               :buttons-no-text="true"
               :button-menu="buttonMenu || getButtonMenu"
               :button-menu-component="buttonMenuComponent"
               :selection="selection"
               uid="id"
               :data="data"
               ref="gallery"
               :sortable="sortable"
               :source-order="sourceOrder"
               :order="!!sourceOrder ? {[sourceOrder]: 'asc'} : {}"
               :server-sorting="serverSorting"
               @sort="sort"
               :scrollable="scrollable"/>
</div>