(() => {
  let mixins = [{
    data(){
      return {
        forum: null,
        topic: null
      };
    },
    methods: {
      shorten: bbn.fn.shorten,
      sdate(d){
        return bbn.fn.fdate(d, true);
      },
      ndate(d){
        return dayjs(d).format('DD/MM/YYYY');
      },
      ndatetime(d){
        return dayjs(d).format('DD/MM/YYYY HH:mm');
      },
      fdate(d){
        return bbn.fn.fdatetime(d, true);
      },
      hour(d){
        return dayjs(d).format('HH:mm')
      },
    },
    created(){
      this.$set(this, 'forum', this.closest('appui-note-forum'));
      this.$set(this, 'topic', this.closest('appui-note-forum-topic'));
    }
  }];
  bbn.vue.addPrefix('appui-note-forum-topic-', (tag, resolve, reject) => {
    return bbn.vue.queueComponent(
      tag,
      appui.plugins['appui-note'] + '/components/forum/topic/' + bbn.fn.replaceAll('-', '/', tag).substr('appui-note-forum-topic-'.length),
      mixins,
      resolve,
      reject
    );
  });

  return {
    mixins: mixins,
    props: {
      source: {
        type: Object
      },
      index: {
        type: Number,
        required: true
      }
    },
    data(){
      return {
        showReplies: false
      }
    },
    methods: {
      toggleReplies(){
        if (this.source.num_replies) {
          if (this.showReplies) {
            this.showReplies = false;
            this.source.replies = false;
          }
          else {
            this.showReplies = true;
          }
        }
        else {
          this.showReplies = false;
          this.source.replies = false;
        }
      },
      togglePinned(){
        let ev = new Event('pin', {
          cancelable: true
        });
        this.forum.$emit('pin', ev, this.source);
        if (!ev.defaultPrevented) {
          this.post(appui.plugins['appui-note'] + '/actions/pin', {
            id: this.source.id,
            pinned: !!this.source.pinned ? 0 : 1
          }, d => {
            if (d.success) {
              this.source.pinned = !!this.source.pinned ? 0 : 1;
              this.forum.updateData();
            }
          });
        }
      },
      updateData(){
        let replies = this.getRef('replies');
        if (replies) {
          replies.updateData();
        }
      }
    }
  }
})();