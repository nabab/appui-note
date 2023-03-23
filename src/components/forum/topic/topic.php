<div class="appui-note-forum-topic bbn-w-100 bbn-spadded">
  <div class="bbn-flex-width bbn-no-border bbn-radius bbn-alt-background">
    <div class="bbn-spadded"
          style="height: 42px; width: 42px">
      <div class="bbn-100 bbn-middle">
        <bbn-initial :user-id="source.creator"
                      :title="forum.usersNames(source.creator, source.users)"/>
        <span v-if="forum.hasEditUsers(source.users)"
              class="bbn-badge bbn-bg-webblue bbn-white appui-note-forum-initial-badge bbn-s"
              v-text="forum.usersNames(source.creator, source.users, true)"/>
      </div>
    </div>
    <div class="bbn-spadded bbn-vmiddle bbn-p appui-note-forum-hfixed appui-note-forum-replies-badge"
          title="<?=_('Replies')?>"
          @click="toggleReplies()">
      <i class="nf nf-fa-comments bbn-xl bbn-hsmargin"/>
      <span :class="['bbn-badge', 'bbn-white', {'bbn-bg-red': !source.num_replies, 'bbn-bg-green': source.num_replies}]"
            v-text="source.num_replies || 0"/>
    </div>
    <div class="bbn-flex-fill bbn-spadded">
      <div v-if="source.title"
            v-text="forum.shorten(source.title, 120)"
            class="bbn-b"
            :title="source.title"/>
      <div ref="contentContainer"
            :style="{'height': contentContainerHeight, 'overflow': 'hidden'}">
        <div class="bbn-flex-width">
          <i v-if="cutContentContainer && possibleHiddenContent"
              class="nf nf-fa-angle_right bbn-p bbn-m"
              title="<?=_('Show full text')?>"
              @click="showContentContainer('auto')"
              style="margin: 0.2rem 0.5rem 0 0; font-weight: bold"/>
            <i v-else-if="!cutContentContainer && possibleHiddenContent"
              class="nf nf-fa-angle_left bbn-p bbn-m"
              title="<?=_('Hidden full text')?>"
              @click="showContentContainer('no_auto')"
              style="margin: 0.2rem 0.5rem 0 0; font-weight: bold"/>
          <div v-html="cutContentContainer ? cutContent : source.content"
                :style="{
                height: contentContainerHeight,
                'text-overflow': cutContentContainer ? 'ellipsis' : 'unset',
                'white-space': cutContentContainer ? 'nowrap' : 'unset',
                width: cutContentContainer ? '100px' : 'unset',
                overflow: cutContentContainer ? 'hidden' : 'unset'
                }"
                class="bbn-flex-fill"/>
          <div v-if="source.links && source.links.length && !cutContentContainer">
            <fieldset class="bbn-widget">
              <legend><?=_("Links:")?></legend>
              <div v-for="l in source.links"
                    style="margin-top: 10px">
                <div class="bbn-flex-width"
                      style="margin-left: 0.5em">
                  <div style="height: 96px">
                    <img v-if="l.name && l.id && forum.imageDom"
                          :src="forum.imageDom + l.id + '/' + l.name">
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
          <div v-if="source.files && source.files.length && !cutContentContainer">
            <fieldset class="bbn-widget">
              <legend><?=_("Files:")?></legend>
              <div v-for="f in source.files">
                <span style="margin-left: 0.5em"
                      :title="f.title">
                  <a class="media bbn-p"
                    @click="forum.downloadMedia(f.id)">
                    <i class="nf nf-fa-download" style="margin-right: 5px"/>
                    <span v-text="f.name"/>
                  </a>
                </span>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
    <template v-if="forum.topicButtons && forum.topicButtons.length"
              v-for="tbtn in forum.topicButtons">
      <div class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed"
            style="margin-left: 0.5rem"
            :title="tbtn.title || ''">
        <i :class="['bbn-xl', 'bbn-p', tbtn.icon]"
            @click="tbtn.action ? tbtn.action(source, _self) : false"/>
      </div>
    </template>
    <div v-if="forum.pinnable"
          class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed"
          style="margin-left: 0.5rem"
          :title="source.pinned ? '<?=\bbn\Str::escapeSquotes(_('unpin'))?>' : '<?=\bbn\Str::escapeSquotes(_('pin'))?>'">
      <i :class="'nf nf-mdi-' + (source.pinned ? 'pin_off bbn-lg' : 'pin') + ' bbn-p'"
          @click="togglePinned"/>
    </div>
    <div v-if="!source.locked"
          class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed"
          style="margin-left: 0.5rem"
          title="<?=_('Delete')?>">
      <i :class="['nf nf-fa-trash', 'bbn-xl', 'bbn-p', {'bbn-disabled': !forum.remove}]"
          @click="forum.remove ? forum.remove(source, _self) : false"
          :style="{backgroundColor: !forum.remove ? 'transparent !important' : ''}"/>
    </div>
    <div v-if="(source.creator === forum.currentUser) || !source.locked || forum.canLock"
          class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed"
          style="margin-left: 0.5rem"
          title="<?=_('Edit')?>">
      <i :class="['nf nf-fa-edit', 'bbn-xl', 'bbn-p', {'bbn-disabled': !forum.edit}]"
          @click="forum.edit ? forum.edit(source, _self) : false"
          :style="{backgroundColor: !forum.edit ? 'transparent !important' : ''}"/>
    </div>
    <div class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed"
          style="margin-left: 0.5rem"
          title="<?=_('Reply')?>">
      <i :class="['nf nf-fa-reply', 'bbn-xl', 'bbn-p', {'bbn-disabled': !forum.reply}]"
          @click="forum.reply ? forum.reply(source, _self) : false"
          :style="{backgroundColor: !forum.reply ? 'transparent !important' : ''}"/>
    </div>
    <div class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed"
          :title="'<?=_('Created')?>: ' + forum.fdate(source.creation) + ((source.creation !== source.last_edit) ? ('\n<?=_('Edited')?>: ' + forum.fdate(source.last_edit)) : '')"
          style="margin-left: 0.5rem;">
      <div>
        <div class="bbn-vmiddle">
          <i :class="['nf nf-fa-calendar', {'bbn-orange': source.creation !== source.last_edit}]"/>
          <div class="bbn-s bbn-left-sspace"
                v-text="forum.ndate(source.creation !== source.last_edit ? source.last_edit : source.creation)"/>
        </div>
        <div class="bbn-vmiddle">
          <i :class="['nf nf-weather-time_3', {'bbn-orange': source.creation !== source.last_edit}]"/>
          <div class="bbn-s bbn-left-sspace"
                v-text="forum.hour(source.creation !== source.last_edit ? source.last_edit : source.creation)"/>
        </div>
      </div>
    </div>
  </div>
  <!-- Replies -->
  <div v-if="showReplies"
        class="bbn-w-100 bbn-bordered-bottom">
    <div v-if="!source.replies"
          class="bbn-middle bbn-padded">
      <?=_('LOADING')?>...
    </div>
    <div v-else>
      <appui-note-forum-topic-post v-for="(r, k) in source.replies"
                                  :source="r"
                                  :key="k"
                                  :index="k"
                                  :last-index="source.replies.length - 1"/>
    </div>
    <!-- Replies footer -->
    <appui-note-forum-topic-pager :source="source"
                                  :key="'appui-note-forum-pager-' + $vnode.key"
                                  ref="pager"/>
  </div>
</div>
