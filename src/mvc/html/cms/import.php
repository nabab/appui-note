<!-- HTML Document -->
<bbn-splitter orientation="horizontal"
              :collapsible="false"
              :resizable="false"
              class="bbn-padded">
	<bbn-pane :size="400">
    <div class="bbn-overlay bbn-flex-height bbn-right-space">
      <div class="bbn-m bbn-upper bbn-b bbn-spadded bbn-alt-background bbn-radius bbn-c bbn-bottom-xsspace bbn-secondary-text-alt"
           v-text="_('Steps')"/>
      <div class="bbn-flex-fill bbn-spadded">
        <bbn-scroll axis="y">
          <div class="bbn-alt-background bbn-spadded bbn-radius">
            <processes-list-item v-for="(pro, i) in processesList"
                               :key="i"
                               :source="pro"
                               :class="{'bbn-bottom-sspace': !!processesList[i+1]}"
                               :list="processesList"/>
          </div>
        </bbn-scroll>
      </div>
    </div>
  </bbn-pane>
  <bbn-pane>
    <div class="bbn-overlay bbn-flex-height">
      <div class="bbn-m bbn-upper bbn-b bbn-spadded bbn-alt-background bbn-radius bbn-c bbn-bottom-xsspace bbn-secondary-text-alt"
           v-text="_('Wordpress XML export file')"/>
      <div class="bbn-spadded bbn-alt-background bbn-radius bbn-flex-width">
        <bbn-button :text="_('Reset import')"
                    icon="nf nf-md-restart bbn-lg"
                    @click="reset"
                    class="bbn-right-space"
                    :disabled="!currentFile"
                    style="border-color: var(--default-background) !important"/>
        <bbn-upload :save-url="root + 'cms/import'"
                    :multi="false"
                    v-model="fileUploaded"
                    :eliminable="false"
                    accept=".xml"
                    :extensions="['xml']"
                    :max="1"
                    class="bbn-flex-fill"
                    ref="uploader"
                    style="border-color: var(--default-background) !important"/>
      </div>
      <div class="bbn-flex-fill">
        <bbn-scroll>
          <div class="bbn-m bbn-upper bbn-b bbn-spadded bbn-alt-background bbn-radius bbn-c bbn-bottom-xsspace bbn-top-space bbn-secondary-text-alt"
               v-text="_('Processes output')"/>
          <div class="bbn-spadded bbn-alt-background bbn-radius bbn-w-100">
            <div v-for="(pro, i) in processesList"
                 :class="['bbn-bordered', 'bbn-radius', 'bbn-flex-width', {'bbn-bottom-sspace': !!processesList[i+1]}]"
                 style="border-color: var(--default-background) !important">
              <div class="bbn-middle bbn-background bbn-spadded bbn-radius-left"
                   style="flex-direction: column; gap: 0.5rem">
                <bbn-button @click="launchProcess(pro)"
                            :title="_('Launch')"
                            icon="nf nf-md-play bbn-xl"
                            :notext="true"
                            style="height: 3rem; border-color: var(--default-background) !important"
                            class="bbn-tertiary"
                            :disabled="(pro.value === 'file') || !processesList[i-1].done || !!pro.done"/>
                <bbn-button @click="undoProcess(pro)"
                            :title="_('Undo')"
                            icon="nf nf-md-restore bbn-xl"
                            :notext="true"
                            style="height: 3rem; border-color: var(--default-background) !important"
                            class="bbn-secondary"
                            :disabled="(pro.value === 'file') || !pro.done"/>
              </div>
              <div class="bbn-flex-fill">
                <div class="bbn-flex-width bbn-b bbn-spadded bbn-background bbn-radius-top-right bbn-vmiddle">
                  <i :class="['bbn-m', {
                       'nf nf-md-check_circle bbn-green': !!pro.done,
                       'nf nf-md-play_circle bbn-blue': !!pro.running,
                       'nf nf-md-dots_circle': !pro.done && !pro.running
                     }]"/>
                  <div v-text="pro.text"
                       class="bbn-flex-fill bbn-left-sspace"/>
                </div>
                <div class="bbn-w-100 bbn-spadded">
                  <span v-text="_('Last message')"/>
                  <span v-if="pro.message?.length"
                        v-text="pro.message"/>
                  <span v-else
                        v-text="_('None')"/>
                </div>
                <div class="bbn-w-100 bbn-spadded">
                  <span v-text="_('Last launch execution time')"/>
                  <span v-if="pro.launchDate?.length"
                        v-text="pro.launchDate"/>
                  <span v-else
                        v-text="_('Never')"/>
                </div>
                <div class="bbn-w-100 bbn-spadded">
                  <span v-text="_('Last undo execution time')"/>
                  <span v-if="pro.undoDate?.length"
                        v-text="pro.undoDate"/>
                  <span v-else
                        v-text="_('Never')"/>
                </div>
              </div>
            </div>
          </div>
        </bbn-scroll>
      </div>
    </div>
  </bbn-pane>
</bbn-splitter>
