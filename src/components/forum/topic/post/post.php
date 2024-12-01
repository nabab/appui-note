<div class="appui-note-forum-topic-post bbn-border bbn-background bbn-radius bbn-spadding">
  <div class="bbn-flex-width bbn-vmiddle">
    <div :class="['appui-note-forum-topic-post-minwidth', 'bbn-unselectable', 'bbn-vmiddle', {'bbn-flex-fill': userFlexFill}]">
      <span class="bbn-vmiddle bbn-right-xspadding bbn-radius bbn-alt-background bbn-border"
            :title="usersNames">
        <bbn-initial :user-name="creatorName"
                     width="1.5rem"
                     height="1.5rem"
                     font-size="0.7rem"
                     class="appui-note-forum-topic-post-norightradius"/>
        <span class="bbn-xspadding bbn-s bbn-unselectable"
              bbn-text="isYou(source.creator) ? _('You') : creatorName"/>
        <span bbn-if="hasEditUsers"
              class="bbn-right-xspadding bbn-b bbn-s bbn-webblue">
          +{{usersNumber}}
        </span>
      </span>
    </div>
    <div bbn-if="!isTopic && isSubReply"
         class="appui-note-forum-topic-post-minwidth bbn-flex-fill bbn-vmiddle bbn-hsspace">
      <i class="nf nf-fa-reply bbn-right-xsspace icon-flip"/>
      <span class="bbn-vmiddle bbn-right-xspadding bbn-radius bbn-alt-background bbn-alt-text bbn-border">
        <bbn-initial :user-id="source.parent_creator"
                     width="1.5rem"
                     height="1.5rem"
                     font-size="0.7rem"
                     class="appui-note-forum-topic-post-norightradius"/>
        <span class="bbn-xspadding bbn-s bbn-unselectable"
              bbn-text="isYou(source.parent_creator) ? _('You') : getUserName(source.parent_creator)"
              :style="{textDecoration: !source.parent_active ? 'line-through' : 'none'}"/>
        <span bbn-text="ndatetime(source.parent_creation)"
              class="bbn-s bbn-right-xspadding bbn-vxspadding"
              :style="{textDecoration: !source.parent_active ? 'line-through' : 'none'}"/>
        <span bbn-if="!source.parent_active"
              class="bbn-right-xspadding bbn-i bbn-s bbn-vxspadding">
          <?= _('deleted') ?>
        </span>
      </span>
    </div>
    <div bbn-if="isTopic && !!source.title"
         class="bbn-vmiddle bbn-flex-fill bbn-hsspace bbn-s"
         style="overflow: hidden;">
      <span bbn-text="shorten(source.title, 120)"
            class="bbn-xspadding bbn-b bbn-ellipsis bbn-m"
            :title="source.title"/>
    </div>
    <div bbn-if="isTopic && !!category"
         class="appui-note-forum-topic-post-minwidth bbn-s bbn-vmiddle bbn-radius bbn-xspadding bbn-alt-background bbn-alt-text bbn-right-sspace bbn-border"
         bbn-text="category"/>
    <div bbn-if="source.files && source.files.length"
         title="<?= _('Files') ?>"
         class="appui-note-forum-topic-post-minwidth appui-note-forum-topic-post-darkgray bbn-radius bbn-vmiddle bbn-right-sspace bbn-xspadding bbn-border">
      <i class="nf nf-md-attachment"/>
      <span class="bbn-b bbn-s bbn-left-xsspace"
            bbn-text="source.files.length"/>
    </div>
    <div bbn-if="source.links && source.links.length"
         title="<?= _('Links') ?>"
         class="appui-note-forum-topic-post-minwidth appui-note-forum-topic-post-darkgray bbn-radius bbn-vmiddle bbn-right-sspace bbn-xspadding bbn-border">
      <i class="nf nf-md-link_variant"/>
      <span class="bbn-b bbn-s bbn-left-xsspace"
            bbn-text="source.links.length"/>
    </div>
    <div bbn-if="!isTopic"
         title="<?= _('Replies') ?>"
         class="appui-note-forum-topic-post-minwidth bbn-alt-background bbn-alt-text bbn-radius bbn-vmiddle bbn-right-sspace bbn-xspadding bbn-border">
      <i class="nf nf-md-forum_outline"/>
      <span :class="['bbn-b', 'bbn-s', 'bbn-left-xsspace', {
              'bbn-red': !source.num_replies,
              'bbn-green': source.num_replies
            }]"
            bbn-text="source.num_replies || 0"/>
    </div>
    <div bbn-text="(source.version > 1 ? 'V' + source.version + ' - ' : '') + ndatetime(isEdited ? source.last_edit : source.creation)"
         :title="dateTitle"
         class="appui-note-forum-topic-post-minwidth bbn-s bbn-radius bbn-xspadding bbn-alt-background bbn-border"/>
  </div>
  <div class="bbn-flex-width bbn-top-sspace">
    <div bbn-if="isTopic && forum.replies">
      <div title="<?= _('Replies') ?>"
           class="bbn-alt-background bbn-alt-text bbn-radius bbn-p bbn-xspadding bbn-vmiddle bbn-border bbn-reactive bbn-right-sspace"
           @click="topic.toggleReplies()">
        <i class="nf nf-md-forum_outline bbn-lg"/>
        <span :class="['bbn-s', 'bbn-b', {
                'bbn-red': !source.num_replies,
                'bbn-green': source.num_replies
              }]"
              bbn-text="source.num_replies || 0"/>
      </div>
    </div>
    <bbn-button icon="nf nf-fa-exclamation"
                :notext="true"
                :text="_('Important')"
                :class="['bbn-right-sspace', {'bbn-bg-red bbn-white': !!source.important}]"
                @click="setUnsetImportant"
                style="min-width: 1.4em; max-width: 1.4em"/>
    <div class="bbn-flex-fill bbn-right-sspace"
         style="overflow: hidden">
      <div ref="contentContainer"
           :style="{'overflow': 'hidden'}"
           class="bbn-w-100">
        <div class="bbn-flex-width">
          <bbn-button bbn-if="hasBigContent"
                      :icon="!!contentVisible ? 'nf nf-fa-angle_down' : 'nf nf-fa-angle_right'"
                      :title="!!contentVisible ? _('Hidden full text') : _('Show full text')"
                      @click="!!contentVisible ? foldContent() : unfoldContent()"
                      :notext="true"
                      class="bbn-alt-background bbn-alt-text bbn-right-xsspace"
                      style="min-width: 1.4em; max-width: 1.4em"/>
          <div class="bbn-flex-fill"
               style="overflow: hidden">
            <div bbn-html="!contentVisible ? cutContent : source.content"
                 :class="['bbn-background', 'bbn-text', 'bbn-radius', 'bbn-xspadding', {'bbn-ellipsis': !contentVisible}]"/>
          </div>
        </div>
        <div bbn-if="source.links && source.links.length && !!contentVisible"
             class="bbn-top-sspace">
          <fieldset class="bbn-background bbn-no-border">
            <legend class="bbn-tertiary bbn-radius bbn-hxspadding"><?= _("Links") ?></legend>
            <div bbn-for="l in source.links"
                 style="margin-top: 10px">
              <div class="bbn-flex-width"
                   style="margin-left: 0.5em">
                <div style="height: 96px">
                  <img bbn-if="l.name && l.id && forum.imageDom"
                        :src="forum.imageDom + l.id + '/' + l.name">
                  <i bbn-else class="nf nf-fa-link"/>
                </div>
                <div class="appui-note-forum-topic-post-link-title bbn-flex-fill bbn-vmiddle">
                  <div>
                    <strong>
                      <a :href="l.content.url"
                         bbn-text="l.title || l.content.url"
                         target="_blank"
                         class="bbn-text"/>
                    </strong>
                    <br>
                    <a bbn-if="l.title"
                       :href="l.content.url"
                       bbn-text="l.content.url"
                       target="_blank"
                       class="bbn-text"/>
                    <br bbn-if="l.title">
                    <span bbn-if="l.content.description"
                          bbn-text="l.content.description"/>
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
        </div>
        <div bbn-if="source.files && source.files.length && !!contentVisible"
             class="bbn-flex-width">
          <div class="bbn-top-sspace bbn-flex">
            <span class="bbn-tertiary bbn-radius bbn-xspadding bbn-right-sspace"
                  bbn-text="_('Files')"/>
          </div>
          <div class="bbn-flex-fill bbn-flex"
               style="flex-wrap: wrap">
            <span bbn-for="f in source.files"
                  :title="f.title"
                  class="bbn-p bbn-alt-background bbn-alt-text bbn-radius bbn-xspadding bbn-right-sspace bbn-top-sspace bbn-vmiddle bbn-border">
              <i class="nf nf-fa-download bbn-right-sspace"
                 @click="forum.downloadMedia(f.id)"/>
              <i bbn-if="f.isImage"
                 class="nf nf-fa-eye bbn-right-sspace"
                 @click="forum.seeImage(f)"/>
              <span bbn-text="f.name"
                    @click="f.isImage ? forum.seeImage(f) : forum.downloadMedia(f.id)"/>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="bbn-vmiddle">
        <!-- Topic's buttons -->
        <bbn-button bbn-if="isTopic && forum.topicButtons && forum.topicButtons.length"
                    bbn-for="(btn, i) in forum.topicButtons"
                    :key="i"
                    class="bbn-alt-background bbn-alt-text bbn-left-sspace"
                    :icon="btn.icon"
                    :notext="true"
                    @click="btn.action ? btn.action(source, _self, topic) : false"
                    :title="btn.title || ''"/>
        <!-- Reply's buttons -->
        <bbn-button bbn-if="!isTopic && forum.replyButtons && forum.replyButtons.length"
                    bbn-for="(btn, i) in forum.replyButtons"
                    :key="i"
                    class="bbn-alt-background bbn-alt-text bbn-left-sspace"
                    :icon="btn.icon"
                    :notext="true"
                    @click="btn.action ? btn.action(source, _self, topic) : false"
                    :title="btn.title || ''"/>
        <!-- Delete -->
        <bbn-button bbn-if="!source.locked && (!isTopic || !source.num_replies)"
                    class="bbn-alt-background bbn-alt-text bbn-left-sspace bbn-bg-red bbn-white"
                    icon="nf nf-fa-trash"
                    :notext="true"
                    @click="forum.removeEnabled ? forum.$emit('remove', source, _self, topic) : false"
                    title="<?= _('Delete') ?>"
                    :disabled="!forum.removeEnabled"/>
        <!-- Edit -->
        <bbn-button bbn-if="(source.creator === forum.currentUser) || !source.locked || forum.canLock"
                    class="bbn-alt-background bbn-alt-text bbn-left-sspace"
                    icon="nf nf-fa-edit"
                    :notext="true"
                    @click="forum.editEnabled ? forum.$emit('edit', source, _self, topic) : false"
                    title="<?= _('Edit') ?>"
                    :disabled="!forum.editEnabled"/>
        <!-- Pin|Unpin -->
        <bbn-button bbn-if="isTopic && forum.pinnable"
                    class="bbn-left-sspace"
                    :icon="'nf nf-mdi-' + (source.pinned ? 'pin_off' : 'pin')"
                    :notext="true"
                    @click="topic.togglePinned"
                    :title="source.pinned ? '<?= _('Unpin')?>' : '<?=_('Pin') ?>'"
                    :style="{
                      backgroundColor: source.pinned ? 'var(--active-background)' : 'var(--alt-background)',
                      color: source.pinned ? 'var(--active-text)' : 'var(--alt-text)'
                    }"/>
        <!-- Reply -->
        <bbn-button bbn-if="forum.replies"
                    class="bbn-alt-background bbn-alt-text bbn-left-sspace"
                    icon="nf nf-fa-reply"
                    :notext="true"
                    @click="forum.replyEnabled ? forum.$emit('reply', source, _self, topic) : false"
                    title="<?= _('Reply') ?>"
                    :disabled="!forum.replyEnabled"/>
      </div>
    </div>
  </div>
</div>