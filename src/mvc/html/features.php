<!-- HTML Document -->

<div class="bbn-overlay">
  <bbn-splitter orientation="horizontal">
    <bbn-pane :size="200">
      <bbn-list :source="source.data"
                source-value="id"
                @select="selectFeature"/>
    </bbn-pane>
    <bbn-pane :scrollable="true">
      <div class="bbn-100">
        <div v-if="selected">
          <div class="bbn-grid-fields bbn-xl bbn-padding bbn-margin-bottom">
            <label> <?= _("Title") ?></label>
            <bbn-input v-model="selectedText"
                       @change="updateOption"/>

            <label> <?= _("Code") ?></label>
            <bbn-input v-model="selectedCode"
                       @change="updateOption"/>

            <label> <?= _("Order") ?></label>
            <bbn-dropdown v-model="selectedOrder"
                          :source="orderModes"
                          @change="updateOption"/>
          </div>
          <div class="bbn-w-100 bbn-spadding"
               v-if="featureItems.length">
            <div class="bbn-spadding bbn-bordered bbn-bottom-smargin bbn-flex-width"
                 v-for="item in featureItems"
                 :key="item.id">
              <div style="width: 150px; max-width: 25vw; min-width: 80px"
                   class="bbn-block">
                <img v-if="item.media"
                     style="width: 100%; height: auto"
                     :src="item.media.url || item.media.path">
                <div v-else
                     class="bbn-w-100 bbn-ratio bbn-middle">
                  <div class="bbn-block">
                    <?= _("No image") ?>
                  </div>
                </div>
              </div>
              <div class="bbn-flex-fill">
                <div v-text="item.title"
                     class="bbn-lg"/>
                <div v-if="selectedOrder === 'manual'">
                  <div v-text="'order: ' + item.num"/>
                  <bbn-button v-if="item.num !== 1"
                              icon="nf nf-fa-arrow_up"
                              @click="setOrderFeature(item.id, item.num - 1)"
                              :notext="true"
                              text="<?= _("Move up") ?>"/>
                  <bbn-button v-if="item.num < featureItems.length"
                              icon="nf nf-fa-arrow_down"
                              @click="setOrderFeature(item.id, item.num + 1)"
                              :notext="true"
                              text="<?= _("Move down") ?>"/>
                </div>
                <bbn-button @click="removeNote(item.id)"
                            icon="nf nf-fa-trash_o"
                            :notext="true"
                            text="<?= _("Delete") ?>"/>
              </div>
            </div>
          </div>
          <div class="bbn-padding">
            <appui-note-picker @select="addNote"/>
          </div>
        </div>
        <div v-else
             class="bbn-overlay bbn-middle">
          <div class="bbn-block">
            <h2>
              <?= _("Pick an element") ?>
            </h2>
          </div>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>
