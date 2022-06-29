<!-- HTML Document -->

<div class="bbn-overlay">
  <bbn-splitter orientation="horizontal">
    <bbn-pane :size="200">
      <bbn-list :source="source.data"
                source-value="id"
                @select="selectFeature">
      </bbn-list>
    </bbn-pane>
    <bbn-pane>
      <div class="bbn-100">
        <div v-if="currentSelected">
          <div class="bbn-grid-fields bbn-xl bbn-padding bbn-margin-bottom">
            <label> <?= _("Title") ?></label>
            <bbn-input v-model="currentSelectedText"></bbn-input>

            <label> <?= _("Code") ?></label>
            <bbn-input v-model="currentSelectedCode"></bbn-input>
          </div>
          <div class="bbn-w-100 bbn-spadding"
               v-if="featureItems.length">
            <div class="bbn-spadding"
                 v-for="item in featureItems">
              <div v-text="item.title"/>
            </div>
          </div>
          <div class="bbn-padding">
            <appui-note-picker @select="selectNote">
            </appui-note-picker>
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
