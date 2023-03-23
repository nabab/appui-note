<div :class="['bbn-flex-width', 'appui-note-forum-replies', 'bbn-bordered-left', 'bbn-no-border-top', 'bbn-no-border-right', {'bbn-alt': !!($vnode.key%2), 'bbn-bordered-bottom': lastIndex !== index}]">
  <div class="bbn-spadded"
        style="height: 42px; width: 42px">
    <div class="bbn-100 bbn-middle">
      <bbn-initial :user-id="source.creator"
                    :title="topic.forum.usersNames(source.creator, source.users)"/>
      <span v-if="topic.forum.hasEditUsers(source.users)"
            class="bbn-badge bbn-bg-webblue appui-note-forum-initial-badge bbn-s"
            v-text="topic.forum.usersNames(source.creator, source.users, true)"/>
    </div>
  </div>
  <div class="bbn-flex-fill bbn-spadded">
    <div v-if="source.id_parent !== source.id_alias"
          class="bbn-vmiddle">
      <i class="nf nf-fa-reply bbn-large icon-flip"/>
      <bbn-initial :user-id="source.parent_creator"
                    :height="20"
                    class="bbn-hsmargin"/>
      <i class="nf nf-fa-calendar"></i>
      <span v-text="topic.forum.ndatetime(source.parent_creation)"
            :style="{
              textDecoration: !source.parent_active ? 'line-through' : 'none',
              marginLeft: '0.3rem'
            }"
            class="bbn-s bbn-s"/>
      <span v-if="!source.parent_active"
            class="bbn-hsmargin bbn-i bbn-s">
        <?=_('deleted')?>
      </span>
    </div>
    <div v-html="source.content"/>
    <div v-if="source.links.length">
      <fieldset class="bbn-widget">
        <legend><?=_("Links:")?></legend>
        <div v-for="l in source.links"
              style="margin-top: 10px">
          <div class="bbn-flex-width"
                style="margin-left: 0.5em">
            <div style="height: 96px">
              <img v-if="l.name && topic.forum.imageDom"
                    :src="topic.forum.imageDom + l.id + '/' + l.name">
              <i v-else class="nf nf-fa-link"/>
            </div>
            <div class="appui-note-forum-link-title bbn-flex-fill bbn-vmiddle">
              <div>
                <strong>
                  <a :href="l.content.url"
                      v-text="l.title || l.content.url"
                      target="_blank"/>
                </strong>
                <br>
                <a v-if="l.title"
                    :href="l.content.url"
                    v-text="l.content.url"
                    target="_blank"/>
                <br v-if="l.title">
                <span v-if="l.content.description"
                      v-text="l.content.description"/>
              </div>
            </div>
          </div>
        </div>
      </fieldset>
    </div>
    <div v-if="source.files.length">
      <fieldset class="bbn-widget">
        <legend><?=_("Files:")?></legend>
        <div v-for="f in source.files">
          <span style="margin-left: 0.5em"
                :title="f.title">
            <a class="media bbn-p"
                @click="topic.forum.downloadMedia(f.id)">
              <i class="nf nf-fa-download" style="margin-right: 5px"/>
              <span v-text="f.name"/>
            </a>
          </span>
        </div>
      </fieldset>
    </div>
  </div>
  <template v-if="topic.forum.replyButtons && topic.forum.replyButtons.length"
            v-for="rbtn in topic.forum.replyButtons">
    <div class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed"
        style="margin-left: 0.5rem"
        :title="rbtn.title || ''">
      <i :class="['bbn-xl', 'bbn-p', rbtn.icon]"
          @click="rbtn.action ? rbtn.action(source, topic.source, _self) : false"/>
    </div>
  </template>
  <div v-if="source.num_replies"
        class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed appui-note-forum-replies-badge"
        title="<?=_('Replies')?>"
        style="margin-left: 0.5rem">
    <i class="nf nf-fa-comments bbn-xl bbn-hsmargin"/>
    <span class="bbn-badge bbn-bg-green bbn-white"
          v-text="source.num_replies"/>
  </div>
  <div v-if="!source.locked && !source.num_replies"
        class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed"
        style="margin-left: 0.5rem"
        title="<?=_('Delete')?>">
    <i class="nf nf-fa-trash bbn-xl bbn-p"
        @click="topic.forum.remove ? topic.forum.remove(source, _self) : false"/>
  </div>
  <div v-if="(source.creator === topic.forum.currentUser) || !source.locked || topic.forum.canLock"
        class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed"
        style="margin-left: 0.5rem"
        title="<?=_('Edit')?>">
    <i class="nf nf-fa-edit bbn-xl bbn-p"
        @click="topic.forum.edit ? topic.forum.edit(source, _self) : false"/>
  </div>
  <div class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed"
        style="margin-left: 0.5rem"
        title="<?=_('Reply')?>">
    <i class="nf nf-fa-reply bbn-xl bbn-p"
        @click="topic.forum.reply ? topic.forum.reply(source, _self) : false"/>
  </div>
  <div class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed"
        :title="'<?=_('Created')?>: ' + topic.forum.fdate(source.creation) + ((source.creation !== source.last_edit) ? ('\n<?=_('Edited')?>: ' + topic.forum.fdate(source.last_edit)) : '')"
        style="margin-left: 0.5rem">
    <div style="margin-left: 0.3rem">
      <div class="bbn-vmiddle">
        <i :class="['nf nf-fa-calendar', {'bbn-orange': source.creation !== source.last_edit}]"/>
        <div class="bbn-s bbn-left-sspace"
            v-text="topic.forum.ndate(source.creation !== source.last_edit ? source.last_edit : source.creation)"/>
      </div>
      <div class="bbn-vmiddle">
        <i :class="['nf nf-weather-time_3', {'bbn-orange': source.creation !== source.last_edit}]"/>
        <div class="bbn-s bbn-left-sspace"
            v-text="topic.forum.hour(source.creation !== source.last_edit ? source.last_edit : source.creation)"/>
      </div>
    </div>
  </div>
</div>