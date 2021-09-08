<div :class="classComponent">
	<div class="bbn-grid-fields bbn-padded">
		<div>Title:</div>
		<div v-text="source.title"></div>
		<div>Filename:</div>
		<div v-text="source.name"></div>
		<div>Type:</div>
		<div v-text="source.type"></div>
		<div>User:</div>
		<div v-text="getField(users, 'text', {value: source.id_user})"></div>
		<div>Size:</div>
    <div v-text="formatBytes(source.content.size)"></div>
    <div>Extension:</div>
    <div v-text="source.content.extension"></div>
    <div class="bbn-grid-full bbn-bordered bbn-radius bbn-spadded bbn-vmargin" v-for="n in source.notes">
      <div class="bbn-grid-fields">
        <div>Note title:</div>
        <div v-text="n.title"></div>
        <div>Creation:</div>
        <div v-text="n.creation"></div>
        <div>Version:</div>
        <div v-text="n.version"></div>
				<div>Published:</div>
        <div v-text="n.is_published ? _('Yes') : _('No') "></div>
        <div>Content:</div>
        <i class="nf nf-mdi-comment_text bbn-medium bbn-p" title="Note content" @click="show_note_content(n)"></i>
      </div>
    </div>
  </div>
</div>
<!-- HTML Document -->

<div>
	<div class="bbn-grid-fields bbn-padded">
		<div>Title:</div>
		<div v-text="source.title"></div>
		<div>Filename:</div>
		<div v-text="source.name"></div>
		<div>Type:</div>
		<div v-text="source.type"></div>
		<div>User:</div>
		<div v-text="getField(users, 'text', {value: source.id_user})"></div>
		<div>Size:</div>
    <div v-text="formatBytes(source.content.size)"></div>
    <div>Extension:</div>
    <div v-text="source.content.extension"></div>
    <div class="bbn-grid-full bbn-bordered bbn-radius bbn-spadded bbn-vmargin" v-for="n in source.notes">
      <div class="bbn-grid-fields">
        <div>Note title:</div>
        <div v-text="n.title"></div>
        <div>Creation:</div>
        <div v-text="n.creation"></div>
        <div>Version:</div>
        <div v-text="n.version"></div>
				<div>Published:</div>
        <div v-text="n.is_published ? _('Yes') : _('No') "></div>
        <div>Content:</div>
        <i class="nf nf-mdi-comment_text bbn-medium bbn-p" title="Note content" @click="show_note_content(n)"></i>
      </div>
    </div>
  </div>
</div>
