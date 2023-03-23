(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    data(){
      return {
        topic: bbn.vue.closest(this, 'appui-note-forum-topic'),
        currentLimit: 10,
        originalData: null,
        start: 0,
        total: 0,
        limits: [10, 25, 50, 100, 250, 500],
        isLoading: false,
        isInit: true
      }
    },
    computed: {
      numPages(){
        return Math.ceil(this.total / this.currentLimit);
      },
      currentPage: {
        get(){
          return Math.ceil((this.start + 1) / this.currentLimit);
        },
        set(val){
          this.start = val > 1 ? (val - 1) * this.currentLimit : 0;
          this.updateData();
        }
      },
      isAjax(){
        return this.topic.forum.isAjax;
      },
      pageable(){
        return this.topic.forum.pageable;
      },
      showPager(){
        return this.isInit && (this.source.num_replies > this.currentLimit);
      }
    },
    methods: {
      updateData(withoutOriginal){
        if ( this.isAjax && !this.isLoading ){
          this.isLoading = true;
          this.$nextTick(() =>{
            let data = {
              limit: this.currentLimit,
              start: this.start,
              data: {id_alias: this.source.id}
            };
            this.post(this.topic.forum.source, data, result =>{
              this.isLoading = false;
              if (
                !result ||
                result.error ||
                ((result.success !== undefined) && !result.success)
              ){
                appui.alert(result && result.error ? result.error : bbn._("Error while updating the data"));
              }
              else {
                this.$set(this.source, 'replies', this.topic.forum._map(result.data || []));
                if ( this.editable ){
                  this.originalData = JSON.parse(JSON.stringify(this.source.replies));
                }
                this.total = result.total || result.data.length || 0;
                this.source.num_replies = this.total;
              }
              this.isInit = true;
            });
          });
        }
        else if ( Array.isArray(this.source.replies) ){
          this.source.replies = this._map(this.source.replies);
          if ( this.isBatch && !withoutOriginal ){
            this.originalData = JSON.parse(JSON.stringify(this.source.replies));
          }
          this.total = this.source.replies.length;
          this.source.num_replies = this.total;
          this.isInit = true;
        }
      }
    },
    mounted(){
      this.$nextTick(() =>{
        this.updateData();
      });
    }
  }
})();