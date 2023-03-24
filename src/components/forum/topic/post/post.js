(() => {
  return {
    props: {
      source: {
        type: Object
      },
      index: {
        type: Number
      },
      lastIndex: {
        type: Number
      }
    },
    data(){
      return {
        contentVisible: true,
        hasBigContent: false
      }
    },
    computed: {
      isTopic(){
        return !this.source.id_alias;
      },
      usersNumber(){
        if (this.source.users) {
          return this.source.users.split(',').length;
        }
        return 0;
      },
      hasEditUsers(){
        return this.usersNumber > 1;
      },
      usersNames(){
        let ret = appui.app.getUserName(this.source.creator.toLowerCase()) || bbn._('Unknown'),
            u;
        if (this.source.users) {
          u = this.source.users.split(',');
          if (u.length > 1) {
            u.forEach((v) => {
              if (v !== this.source.creator) {
                ret += ', ' + appui.app.getUserName(v.toLowerCase()) || bbn._('Unknown');
              }
            });
          }
        }
        return ret;
      },
      cutContent(){
        return bbn.fn.html2text(this.source.content).replace(/\n/g, ' ');
      },
      creatorName(){
        return appui.app.getUserName(this.source.creator);
      }
    },
    methods: {
      showContent(){
        this.contentVisible = true;
      },
      hideContent(){
        this.contentVisible = false;
      },
      isYou(id){
        return id === appui.app.user.id;
      }
    },
    mounted(){
      this.$nextTick(() => {
        if (this.isTopic
          && (this.getRef('contentContainer').getBoundingClientRect().height > 35)
        ) {
          this.hasBigContent = true;
          this.hideContent();
        }
      });
    }
  }
})();