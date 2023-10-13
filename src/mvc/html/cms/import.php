<!-- HTML Document -->
<bbn-splitter orientation="horizontal"
              :collapsible="false"
              :resizable="false"
              class="bbn-padded">
	<bbn-pane :size="400">
    <div class="bbn-overlay bbn-flex-height bbn-right-space">
      <div class="bbn-m bbn-upper bbn-b bbn-spadded bbn-alt-background bbn-radius bbn-c bbn-bottom-xsspace bbn-secondary-text-alt"><?=_("Steps")?></div>
      <div class="bbn-flex-fill bbn-spadded">
        <bbn-scroll axis="y">
          <div class="bbn-alt-background bbn-spadded bbn-radius">
            <process-list-item v-for="(pro, i) in processList"
                               :key="i"
                               :source="pro"
                               :class="{'bbn-bottom-sspace': !!processList[i+1]}"/>
          </div>
          <bbn-list :source="source.filesList"
                    @select="selectProcess"
                    class="bbn-alt-background bbn-spadded bbn-radius bbn-top-sspace"/>
        </bbn-scroll>
      </div>
    </div>
  </bbn-pane>
  <bbn-pane>
    <div class="bbn-overlay bbn-flex-height">
      <div class="bbn-m bbn-upper bbn-b bbn-spadded bbn-alt-background bbn-radius bbn-c bbn-bottom-xsspace bbn-secondary-text-alt"><?=_("Wordpress XML export file")?></div>
      <div class="bbn-spadded bbn-alt-background bbn-radius bbn-flex-width">
        <bbn-button :text="_('Reset import')"
                    icon="nf nf-md-restart bbn-lg"
                    @click="reset"
                    class="bbn-right-space"
                    :disabled="!currentFile"/>
        <bbn-upload :save-url="root + 'cms/import'"
                    :multi="false"
                    v-model="fileUploaded"
                    :eliminable="false"
                    accept=".xml"
                    :extensions="['xml']"
                    :max="1"
                    class="bbn-flex-fill"
                    ref="uploader"/>
      </div>
      <div class="bbn-flex-fill">
        <bbn-scroll>
          <div class="bbn-m bbn-upper bbn-b bbn-spadded bbn-alt-background bbn-radius bbn-c bbn-bottom-xsspace bbn-top-space bbn-secondary-text-alt"><?=_("Process")?></div>
          <div class="bbn-spadded bbn-alt-background bbn-radius bbn-w-100">
            <template v-if="selectedProcess">
              <h2 v-text="selectedProcess"/>
              <bbn-button @click="launchProcess"><?=_("Launch")?></bbn-button>
              <bbn-button @click="undoProcess"><?=_("Undo")?></bbn-button>
              <h3><?=_("Info")?></h3>
              <div class="bbn-w-100 bbn-spadded">
                <span><?= _("Last info message") ?></span>
                <span v-if="infoMessage"
                      v-text="infoMessage"/>
                <span v-else><?= _("None") ?></span>
              </div>
              <div class="bbn-w-100 bbn-spadded bbn-red"
                   v-text="message"/>
              <div class="bbn-w-100 bbn-spadded">
                <span><?= _("Last launch execution time") ?></span>
                <span v-if="lastLaunch"
                      v-text="lastLaunch"/>
                <span v-else><?= _("Never") ?></span>
              </div>
              <div class="bbn-w-100 bbn-spadded">
                <?= _("Last undo execution time") ?>
                <span v-if="lastUndo"
                      v-text="lastUndo"/>
                <span v-else><?= _("Never") ?></span>
              </div>
            </template>
            <div v-else
                 class="bbn-c">
              <?=_("Please select a process")?>
            </div>
          </div>
        </bbn-scroll>
      </div>
    </div>
  </bbn-pane>
</bbn-splitter>
