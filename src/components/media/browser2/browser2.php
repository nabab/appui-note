<div class="bbn-flex-height bbn-background bbn-overlay" ref="browser">
  <bbn-gallery :source="source"
               :pageable="pageable"
               :filterable="filterable"
               :limit="limit"
               :zoomable="zoomable"
               :path-name="pathName"
               :toolbar="true"
               :uploadButton="addMedia"
               :downloadButton="downloadMedia"
               :removeButton="deleteMedia"
               :buttons-no-text="true"
               :buttonMenu="[{text:'ciao'}]"
               :context="[{text:'ciao'}]"/>
</div>