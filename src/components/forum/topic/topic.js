(() => {
  return {
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
        forum: bbn.vue.closest(this, 'appui-note-forum'),
        currentLimit: this.limit,
        start: 0,
        total: 0,
        limits: [10, 25, 50, 100, 250, 500],
        isLoading: false,
        showReplies: false,
        contentContainerHeight: 'auto',
        possibleHiddenContent: false
      }
    },
    computed: {
      cutContentContainer(){
        return this.contentContainerHeight !== 'auto';
      },
      cutContent(){
        return bbn.fn.html2text(this.source.content).replace(/\n/g, ' ');
      }
    },
    methods: {
      showContentContainer(val){
        this.contentContainerHeight = val;
      },
      toggleReplies(){
        if ( this.source.num_replies ){
          if ( this.showReplies ){
            this.showReplies = false;
            this.source.replies = false;
          }
          else {
            this.showReplies = true;
          }
        }
      },
      togglePinned(){
        let ev = new Event('pin', {
          cancelable: true
        });
        this.forum.$emit('pin', this.source, ev);
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
      }
    },
    mounted(){
      this.$nextTick(() => {
        // if ( this.getRef('contentContainer').clientHeight > 35 ){
        if ( this.getRef('contentContainer').getBoundingClientRect().height > 35 ){
          this.contentContainerHeight = '35px';
          this.possibleHiddenContent = true;
        }
      });
    }
  }
})();