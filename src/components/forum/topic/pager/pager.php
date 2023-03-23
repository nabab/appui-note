<div class="appui-note-forum-pager bbn-widget appui-note-forum-replies bbn-no-border-bottom bbn-no-border-right bbn-no-border-top"
      v-if="pageable || isAjax"
      v-show="showPager">
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
    <bbn-numeric v-if="source.replies && source.replies.length"
                  v-model="currentPage"
                  :min="1"
                  :max="numPages"
                  style="margin-right: 0.5em; width: 6em"
                  :disabled="isLoading"/>
    <span v-text="'<?=_('of')?>' + ' ' + numPages" style="margin-right: 0.25em"></span>
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
          v-text="total ? '<?=_('Total')?>: ' + total + ' <?=_('items')?>' : '<?=_('No item')?>'"/>
    &nbsp;
    <bbn-button v-if="isAjax"
                title="<?=_('Refresh')?>"
                @click="updateData"
                icon="nf nf-fa-refresh"/>
  </div>
</div>