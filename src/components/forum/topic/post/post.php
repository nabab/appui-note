<div class="appui-note-forum-topic-post bbn-no-border bbn-alt-background bbn-radius bbn-spadded">
  <div class="bbn-flex-width">
    <div class="bbn-vmiddle bbn-flex-fill">
      <span class="bbn-vmiddle bbn-right-spadded bbn-radius bbn-background"
            :title="usersNames">
        <bbn-initial :user-name="creatorName"
                     width="1.2rem"
                     height="1.2rem"
                     font-size="0.7rem"
                     class="appui-note-forum-topic-post-norightradius"/>
        <span class="bbn-left-xsspace bbn-s bbn-unselectable"
              v-text="isYou(source.creator) ? _('You') : creatorName"/>
        <span v-if="hasEditUsers"
              class="bbn-left-xspadded bbn-b bbn-s bbn-webblue">
          +{{usersNumber}}
        </span>
      </span>
    </div>
    <div v-if="source.creation === source.last_edit"
         v-text="ndatetime(source.creation)"
         :title="_('Created at')"
         class="bbn-s bbn-vmiddle bbn-radius bbn-hspadded bbn-background"/>
    <div v-else
         v-text="ndatetime(source.last_edit)"
         :title="_('Updated at')"
         class="bbn-s bbn-vmiddle bbn-radius bbn-hspadded bbn-background"/>
  </div>
  <div class="bbn-flex-width">
    <div v-if="isTopic"
         class="bbn-vmiddle bbn-top-spadded">
      <div title="<?=_('Replies')?>"
           class="bbn-background bbn-radius bbn-p bbn-xspadded bbn-vmiddle"
           @click="topic.toggleReplies()">
        <i class="nf nf-md-android_messages bbn-xl icon-full-flip"
           style="align-self: flex-start;"/>
        <span :class="['bbn-s', 'bbn-b', {
                'bbn-red': !source.num_replies,
                'bbn-green': source.num_replies
              }]"
              v-text="source.num_replies || 0"
              style="align-self: flex-end;"/>
      </div>
    </div>
    <div class="bbn-flex-fill bbn-hspadded bbn-top-spadded">
      <div v-if="isTopic && !!source.title"
              v-text="shorten(source.title, 120)"
              class="bbn-b bbn-ellipsis"
              :title="source.title"/>
      <div v-if="!isTopic && (source.id_parent !== source.id_alias)"
            class="bbn-vmiddle">
        <i class="nf nf-fa-reply bbn-large icon-flip"/>
        <bbn-initial :user-id="source.parent_creator"
                     :height="20"
                     class="bbn-hsmargin"/>
        <i class="nf nf-fa-calendar"/>
        <span v-text="ndatetime(source.parent_creation)"
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
      <div ref="contentContainer"
           :style="{'overflow': 'hidden'}">
        <div class="bbn-flex-width">
          <i v-if="!contentVisible && hasBigContent"
              class="nf nf-fa-angle_right bbn-p bbn-m"
              title="<?=_('Show full text')?>"
              @click="showContent"
              style="margin: 0.2rem 0.5rem 0 0; font-weight: bold"/>
          <i v-else-if="!!contentVisible && hasBigContent"
              class="nf nf-fa-angle_left bbn-p bbn-m"
              title="<?=_('Hidden full text')?>"
              @click="hideContent()"
              style="margin: 0.2rem 0.5rem 0 0; font-weight: bold"/>
          <div v-html="!contentVisible ? cutContent : source.content"
                :style="{
                  width: !contentVisible ? '100px' : 'unset',
                }"
                :class="['bbn-flex-fill', {'bbn-ellipsis': !contentVisible}]"/>
          <div v-if="source.links && source.links.length && !!contentVisible">
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
          <div v-if="source.files && source.files.length && !!contentVisible">
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
    <div class="bbn-top-spadded bbn-vmiddle">
      <div v-if="!isTopic && source.num_replies"
            class="bbn-spadded bbn-vmiddle appui-note-forum-hfixed appui-note-forum-replies-badge"
            title="<?=_('Replies')?>"
            style="margin-left: 0.5rem">
        <i class="nf nf-fa-comments bbn-xl bbn-hsmargin"/>
        <span class="bbn-badge bbn-bg-green bbn-white"
              v-text="source.num_replies"/>
      </div>
      <!-- Topic buttons -->
      <bbn-button v-if="isTopic && forum.topicButtons && forum.topicButtons.length"
                  v-for="(btn, i) in forum.topicButtons"
                  :key="i"
                  class="bbn-no-border bbn-background bbn-text bbn-lg bbn-left-sspace"
                  :icon="btn.icon"
                  :notext="true"
                  @click="btn.action ? btn.action(source, _self, topic) : false"
                  :title="btn.title || ''"/>
      <!-- Reply buttons -->
      <bbn-button v-if="!isTopic && forum.replyButtons && forum.replyButtons.length"
                  v-for="(btn, i) in forum.replyButtons"
                  :key="i"
                  class="bbn-no-border bbn-background bbn-text bbn-lg bbn-left-sspace"
                  :icon="btn.icon"
                  :notext="true"
                  @click="btn.action ? btn.action(source, _self, topic) : false"
                  :title="btn.title || ''"/>
      <!-- Pin|Unpin -->
      <bbn-button v-if="isTopic && forum.pinnable"
                  class="bbn-no-border bbn-background bbn-text bbn-lg bbn-left-sspace"
                  :icon="'nf nf-mdi-' + (source.pinned ? 'pin_off' : 'pin')"
                  :notext="true"
                  @click="topic.togglePinned"
                  :title="source.pinned ? '<?=_('Unpin')?>' : '<?=_('Pin')?>'"/>
      <!-- Delete -->
      <bbn-button v-if="!source.locked && !source.num_replies"
                  class="bbn-no-border bbn-background bbn-text bbn-lg bbn-left-sspace"
                  icon="nf nf-fa-trash"
                  :notext="true"
                  @click="forum.removeEnabled ? forum.$emit('remove', source, _self, topic) : false"
                  title="<?=_('Delete')?>"
                  :disabled="!forum.removeEnabled"/>
      <!-- Edit -->
      <bbn-button v-if="(source.creator === forum.currentUser) || !source.locked || forum.canLock"
                  class="bbn-no-border bbn-background bbn-text bbn-lg bbn-left-sspace"
                  icon="nf nf-fa-edit"
                  :notext="true"
                  @click="forum.editEnabled ? forum.$emit('edit', source, _self, topic) : false"
                  title="<?=_('Edit')?>"
                  :disabled="!forum.editEnabled"/>
      <!-- Reply -->
      <bbn-button class="bbn-no-border bbn-background bbn-text bbn-lg bbn-left-sspace"
                  icon="nf nf-fa-reply"
                  :notext="true"
                  @click="forum.replyEnabled ? forum.$emit('reply', source, _self, topic) : false"
                  title="<?=_('Reply')?>"
                  :disabled="!forum.replyEnabled"/>
    </div>
  </div>
</div>