<!-- HTML Document -->

<div :class="componentClass">
	<div class="bbn-grid-fields bbn-padded">
		<div><?= _("Title") ?></div>
		<div v-text="source.title"></div>

    <div><?= _("Filename") ?>:</div>
		<div v-text="source.name"></div>

    <div v-if="source.description"><?= _("Description") ?></div>
    <div v-if="source.description"
         v-text="source.description"/>

    <div><?= _("Type") ?></div>
		<div v-text="type"/>

    <div><?= _("MIME type") ?></div>
		<div v-text="source.mimetype"/>

    <div><?= _("User") ?></div>
		<div v-text="getField(users, 'text', {value: source.id_user})"/>

    <div><?= _("Size") ?></div>
    <div v-text="formatBytes(source.content.size)"/>

    <div><?= _("Extension") ?></div>
    <div v-text="source.content.extension"/>

    <div v-if="source.path"><?= _("URL") ?></div>
    <div v-if="source.path">
      <a :href="source.path"
         target="_blank"
         v-text="source.path"/>
    </div>

    <div> </div>
    <div>
    	<a href="javascript:;"
         @click="openDetails">
      	<?= _("Show details") ?>
      </a>
    </div>

    <div class="bbn-grid-full bbn-bordered bbn-radius bbn-spadded bbn-vmargin"
         v-for="n in source.notes">
      <div class="bbn-grid-fields">
        <div><?= _("Note title") ?></div>
        <div v-text="n.title"></div>

        <div><?= _("Creation") ?></div>
        <div v-text="n.creation"></div>

        <div><?= _("Version") ?></div>
        <div v-text="n.version"></div>

        <div><?= _("Published") ?></div>
        <div v-text="n.is_published ? _('Yes') : _('No') "></div>

        <div><?= _("Content") ?></div>
        <i class="nf nf-mdi-comment_text bbn-medium bbn-p"
           title="<?= _("Note content") ?>"
           @click="show_note_content(n)"/>
      </div>
    </div>
  </div>
</div>
