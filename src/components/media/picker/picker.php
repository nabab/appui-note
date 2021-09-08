<!-- HTML Document -->

<div :class="[componentClass, 'bbn-flex-height', 'bbn-background', 'bbn-overlay']" ref="browser">
  <bbn-gallery :source="source"
               :searchName="searchName"
               :pageable="pageable"
               :filterable="filterable"
               :limit="limit"
               :zoomable="false"
               :info="info"
               :path-name="pathName"
               :overlay-name="overlayName"
               :overlay="overlay"
               :toolbar="true"
               :uploadable="uploadEnabled"
               :deletable="removeEnabled"
               @upload="addMedia"
               @download="downloadMedia"
               @delete="removeMedia"
               @clickItem="emitClickItem"
               :buttons-no-text="true"
               :buttonMenu="currentButtonMenu"
               :buttonMenuComponent="buttonMenuComponent"/>
</div>
