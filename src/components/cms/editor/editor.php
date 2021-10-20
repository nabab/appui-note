<!-- HTML Document -->
<div :class="[componentClass, 'bbn-overlay', 'bbn-flex-height']">
  <bbn-toolbar class="bbn-header">
    <span class="bbn-lg bbn-b bbn-left-space"
         v-text="source.title"/>
    <div/>
    <bbn-button class="bbn-left-sspace nf nf-fa-save bbn-lg"
                title="<?= _("Save the note") ?>"
                :notext="true"
                :disabled="!isChanged"
                @click="() => {$refs.form.submit()}"/>
    <bbn-button class="bbn-left-sspace nf nf-mdi-cursor_default_outline bbn-lg"
                title="<?= _("Select the note") ?>"
                :disabled="!ready || ($refs.editor.currentEdited === -1)"
                :notext="true"
                @click="() => {$refs.editor.currentEdited = -1}"/>
    <bbn-context class="bbn-left-sspace"
                 :source="contextSource">
      <bbn-button class="nf nf-mdi-plus_outline bbn-lg"
                  :notext="true"
                  secondary="nf nf-fa-caret_down"
                  text="<?= _("Add a new block") ?>"/>
    </bbn-context>
  </bbn-toolbar>
  <div class="bbn-flex-fill">
    <bbn-form ref="form"
              class="bbn-hidden"
              :source="source"
              :action="root + 'cms/actions/save'"
              :buttons="[]"/>
    <appui-note-cms-elementor :source="source.items"
                              @hook:mounted="ready = true"
                              ref="editor">
      <slot/>
    </appui-note-cms-elementor>
  </div>
</div>
