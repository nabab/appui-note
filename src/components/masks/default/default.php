<div class="appui-note-masks-default bbn-spadding"
     style="display: block">
  <div bbn-if="source.default">
    <i class="nf nf-fa-check bbn-green"/>
  </div>
  <bbn-button bbn-else
              icon="nf nf-fa-check bbn-red"
              @click="setDefault"
              :notext="true"/>
</div>
