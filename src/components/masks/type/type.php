<div class="bbn-flex-width bbn-vmiddle">
  <div class="bbn-flex-fill">
    <span bbn-text="source.type"/>
    (<span bbn-text="num"/>)
  </div>
  <div>
    <bbn-button bbn-if="isDev"
                @click="editCategory"
                icon="nf nf-fa-edit"
                label="<?= _('Edit category') ?>"/>
    <bbn-button @click="insert"
                icon="nf nf-fa-plus"
                label="<?= _('Add letter') ?>"/>
  </div>
</div>