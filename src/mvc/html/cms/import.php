<!-- HTML Document -->
<bbn-splitter :resizable="true"
              orientation="horizontal">
	<bbn-pane :size="200">
    <bbn-list :source="processList"
              @select="selectProcess"/>
  </bbn-pane>
  <bbn-pane>
    <bbn-upload :save-url="root + 'cms/import'"
                :multi="false"
                v-model="fileUploaded"
                :eliminable="false"
                accept=".xml"
                :extensions="['xml']"
                :max="1"/>
    <div class="bbn-padded"
         v-if="selectedProcess">
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
    </div>
    <div class="bbn-overlay bbn-middle"
         v-else>
      <h1><?=_("Please select a process")?></h1>
    </div>
  </bbn-pane>
</bbn-splitter>
