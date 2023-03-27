<div class="appui-note-forum-topic-post bbn-no-border bbn-alt-background bbn-radius bbn-spadded">
  <div class="bbn-flex-width bbn-vmiddle">
    <div :class="['bbn-unselectable', 'bbn-vmiddle', {'bbn-flex-fill': userFlexFill}]">
      <span class="bbn-vmiddle bbn-right-xspadded bbn-radius bbn-background"
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
    <div v-if="!isTopic && isSubReply"
         class="bbn-flex-fill bbn-vmiddle bbn-hsspace">
      <i class="nf nf-fa-reply bbn-right-xsspace icon-flip"/>
      <span class="bbn-vmiddle bbn-right-xspadded bbn-radius bbn-background">
        <bbn-initial :user-id="source.parent_creator"
                     width="1.2rem"
                     height="1.2rem"
                     font-size="0.7rem"
                     class="appui-note-forum-topic-post-norightradius"/>
        <span class="bbn-left-xsspace bbn-s bbn-unselectable"
              v-text="isYou(source.parent_creator) ? _('You') : getUserName(source.parent_creator)"
              :style="{textDecoration: !source.parent_active ? 'line-through' : 'none'}"/>
        <span v-text="ndatetime(source.parent_creation)"
              class="bbn-s bbn-left-xsspace"
              :style="{textDecoration: !source.parent_active ? 'line-through' : 'none'}"/>
        <span v-if="!source.parent_active"
              class="bbn-hsmargin bbn-i bbn-s">
          <?=_('deleted')?>
        </span>
      </span>
    </div>
    <div v-if="isTopic && !!source.title"
         class="bbn-vmiddle bbn-flex-fill bbn-hsspace">
      <span v-text="shorten(source.title, 120)"
            class="bbn-radius bbn-hxspadded bbn-b bbn-ellipsis bbn-background-secondary bbn-secondary-text"
            :title="source.title"/>
    </div>
    <div v-if="isTopic && !!type"
         class="bbn-s bbn-vmiddle bbn-radius bbn-hxspadded bbn-background-tertiary bbn-tertiary-text bbn-right-sspace"
         v-text="type"/>
    <div v-if="!isTopic"
         title="<?=_('Replies')?>"
         class="bbn-background bbn-radius bbn-flex bbn-right-sspace bbn-hxspadded">
      <i class="nf nf-md-forum_outline"/>
      <span :class="['bbn-b', 'bbn-s', 'bbn-left-xsspace', {
              'bbn-red': !source.num_replies,
              'bbn-green': source.num_replies
            }]"
            v-text="source.num_replies || 0"/>
    </div>
    <div v-text="ndatetime(isEdited ? source.last_edit : source.creation)"
         :title="isEdited ? _('Updated at') : _('Created at')"
         class="bbn-s bbn-vmiddle bbn-radius bbn-hxspadded bbn-background"/>
  </div>
  <div class="bbn-flex-width bbn-top-sspace">
    <div v-if="isTopic">
      <div title="<?=_('Replies')?>"
           class="bbn-background bbn-radius bbn-p bbn-xspadded bbn-vmiddle"
           @click="topic.toggleReplies()">
        <i class="nf nf-md-forum_outline bbn-lg"/>
        <span :class="['bbn-s', 'bbn-b', {
                'bbn-red': !source.num_replies,
                'bbn-green': source.num_replies
              }]"
              v-text="source.num_replies || 0"/>
      </div>
    </div>
    <div :class="['bbn-flex-fill', 'bbn-right-sspace', {'bbn-left-sspace': isTopic}]"
         style="overflow: hidden">
      <div ref="contentContainer"
           :style="{'overflow': 'hidden'}"
           class="bbn-w-100">
        <div class="bbn-flex-width">
          <bbn-button v-if="hasBigContent"
                      :icon="!!contentVisible ? 'nf nf-fa-angle_down' : 'nf nf-fa-angle_right'"
                      :title="!!contentVisible ? _('Hidden full text') : _('Show full text')"
                      @click="!!contentVisible ? hideContent() : showContent()"
                      :notext="true"
                      class="bbn-no-border bbn-right-xsspace"
                      style="min-width: 1.4em; max-width: 1.4em"/>
          <div class="bbn-flex-fill"
               style="overflow: hidden">
            <div v-html="!contentVisible ? cutContent : source.content"
                 :class="['bbn-background', 'bbn-radius', 'bbn-xspadded', {'bbn-ellipsis': !contentVisible}]"/>
          </div>
        </div>
        <div v-if="source.links && source.links.length && !!contentVisible"
             class="bbn-top-sspace">
          <fieldset class="bbn-background bbn-no-border">
            <legend class="bbn-tertiary bbn-radius bbn-hxspadded"><?=_("Links")?></legend>
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
                         target="_blank"
                         class="bbn-text"/>
                    </strong>
                    <br>
                    <a v-if="l.title"
                       :href="l.content.url"
                       v-text="l.content.url"
                       target="_blank"
                       class="bbn-text"/>
                    <br v-if="l.title">
                    <span v-if="l.content.description"
                          v-text="l.content.description"/>
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
        </div>
        <div v-if="source.files && source.files.length && !!contentVisible"
             class="bbn-top-sspace bbn-flex-width">
          <span class="bbn-tertiary bbn-radius bbn-hxspadded bbn-right-sspace"
                v-text="_('Files')"/>
          <diV class="bbn-flex-fill bbn-flex">
            <span v-for="f in source.files"
                  :title="f.title"
                  @click="forum.downloadMedia(f.id)"
                  class="bbn-p bbn-background bbn-text bbn-radius bbn-hxspadded bbn-right-sspace">
              <i class="nf nf-fa-download bbn-right-sspace"/>
              <span v-text="f.name"/>
            </span>
          </diV>
        </div>
      </div>
    </div>
    <div>
      <div class="bbn-vmiddle">
        <!-- Topic buttons -->
        <bbn-button v-if="isTopic && forum.topicButtons && forum.topicButtons.length"
                    v-for="(btn, i) in forum.topicButtons"
                    :key="i"
                    class="bbn-no-border bbn-background bbn-text bbn-left-sspace"
                    :icon="btn.icon"
                    :notext="true"
                    @click="btn.action ? btn.action(source, _self, topic) : false"
                    :title="btn.title || ''"/>
        <!-- Reply buttons -->
        <bbn-button v-if="!isTopic && forum.replyButtons && forum.replyButtons.length"
                    v-for="(btn, i) in forum.replyButtons"
                    :key="i"
                    class="bbn-no-border bbn-background bbn-text bbn-left-sspace"
                    :icon="btn.icon"
                    :notext="true"
                    @click="btn.action ? btn.action(source, _self, topic) : false"
                    :title="btn.title || ''"/>
        <!-- Pin|Unpin -->
        <bbn-button v-if="isTopic && forum.pinnable"
                    class="bbn-no-border bbn-background bbn-text bbn-left-sspace"
                    :icon="'nf nf-mdi-' + (source.pinned ? 'pin_off' : 'pin')"
                    :notext="true"
                    @click="topic.togglePinned"
                    :title="source.pinned ? '<?=_('Unpin')?>' : '<?=_('Pin')?>'"/>
        <!-- Delete -->
        <bbn-button v-if="!source.locked && (!isTopic || !source.num_replies)"
                    class="bbn-no-border bbn-background bbn-text bbn-left-sspace bbn-bg-red bbn-white"
                    icon="nf nf-fa-trash"
                    :notext="true"
                    @click="forum.removeEnabled ? forum.$emit('remove', source, _self, topic) : false"
                    title="<?=_('Delete')?>"
                    :disabled="!forum.removeEnabled"/>
        <!-- Edit -->
        <bbn-button v-if="(source.creator === forum.currentUser) || !source.locked || forum.canLock"
                    class="bbn-no-border bbn-background bbn-text bbn-left-sspace"
                    icon="nf nf-fa-edit"
                    :notext="true"
                    @click="forum.editEnabled ? forum.$emit('edit', source, _self, topic) : false"
                    title="<?=_('Edit')?>"
                    :disabled="!forum.editEnabled"/>
        <!-- Reply -->
        <bbn-button class="bbn-no-border bbn-background bbn-text bbn-left-sspace"
                    icon="nf nf-fa-reply"
                    :notext="true"
                    @click="forum.replyEnabled ? forum.$emit('reply', source, _self, topic) : false"
                    title="<?=_('Reply')?>"
                    :disabled="!forum.replyEnabled"/>
      </div>
    </div>
  </div>
</div>