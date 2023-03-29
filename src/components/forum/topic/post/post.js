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
        return this.source.id === this.topic.source.id;
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
      },
      isEdited(){
        return this.source.creation !== this.source.last_edit;
      },
      category(){
        if (!!this.forum.categories
          && this.forum.categories.length
          && !!this.source.category
        ) {
          return bbn.fn.getField(this.forum.categories, 'text', 'value', this.source.category);
        }
        return '';
      },
      isSubReply(){
        return this.source.id_parent !== this.source.id_alias;
      },
      userFlexFill(){
        return (this.isTopic && !this.source.title) || (!this.isTopic && !this.isSubReply);
      }
    },
    methods: {
      getUserName: appui.app.getUserName,
      unfoldContent(){
        this.contentVisible = true;
      },
      foldContent(){
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
          if (!this.forum.autoUnfoldCats
            || !this.source.category
            || (bbn.fn.isArray(this.forum.autoUnfoldCats)
              && !this.forum.autoUnfoldCats.includes(this.source.category)
            )
          ) {
            this.foldContent();
          }
        }
      });
    }
  }
})();