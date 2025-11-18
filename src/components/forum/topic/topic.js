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
        return bbn.date(d).format('DD/MM/YYYY');
      },
      ndatetime(d){
        return bbn.date(d).format('DD/MM/YYYY HH:mm');
      },
      fdate(d){
        return bbn.fn.fdatetime(d, true);
      },
      hour(d){
        return bbn.date(d).format('HH:mm')
      },
    },
    created(){
      this.$set(this, 'forum', this.closest('appui-note-forum'));
      this.$set(this, 'topic', this.closest('appui-note-forum-topic'));
    }
  }];
  bbn.cp.addPrefix('appui-note-forum-topic-', null, mixins);

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
    computed: {
      filters(){
        if (this.forum.filterable
          && this.forum.search
          && this.forum.filterString.length
        ) {
          return {
            logic: 'OR',
            conditions: [{
              field: 'title',
              operator: 'contains',
              value: this.forum.filterString
            }, {
              field: 'content',
              operator: 'contains',
              value: this.forum.filterString
            }]
          }
        }
        return {};
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