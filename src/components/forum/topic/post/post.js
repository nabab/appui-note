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
        hasBigContent: false,
        usersList: ''
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
        return this.getUsersNames(this.source.users.split(','));
      },
      cutContent(){
        return bbn.fn.html2text(this.source.content).replace(/\n/g, ' ');
      },
      creatorName(){
        return appui.getUserName(this.source.creator);
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
      },
      dateTitle(){
        let ret = bbn._('Created at %s', this.ndatetime(this.source.creation));
        if (this.isEdited) {
          ret += "\n" + bbn._('Updated at %s', this.ndatetime(this.source.last_edit));
        }
        return ret;
      }
    },
    methods: {
      getUserName: appui.getUserName,
      unfoldContent(){
        this.contentVisible = true;
      },
      foldContent(){
        this.contentVisible = false;
      },
      isYou(id){
        return id === appui.user.id;
      },
      setUnsetImportant(){
        this.post(appui.plugins['appui-note'] + '/actions/update', {
          id_note: this.source.id,
          important: !this.source.important
        }, d => {
          if (d.success) {
            this.source.important = !!this.source.important ? 0 : 1;
            appui.success();
          }
          else {
            appui.error();
          }
        })
      },
      getUsersNames(users){
        let ret = appui.getUserName(this.source.creator.toLowerCase()) || bbn._('Unknown');
        if (users?.length > 1) {
          users.forEach((v) => {
            if (v.toLowerCase() !== this.source.creator.toLowerCase()) {
              ret += ', ' + appui.getUserName(v.toLowerCase()) || bbn._('Unknown');
            }
          });
        }
        return ret;
      },
      async getUsersList(){
        if (!this.usersList.length) {
          const d = await this.post(appui.plugins['appui-note'] + '/data/userslist', {
            id: this.source.id
          });
          bbn.fn.log('mirko', d)
          if (d?.data?.success && bbn.fn.isArray(d?.data?.data)) {
            this.usersList = this.getUsersNames(d.data.data);
          }
        }

        return this.usersList;
      }
    },
    mounted(){
      this.$nextTick(() => {
        setTimeout(() => {
          if (this.isTopic
            && (this.getRef('contentContainer').getBoundingClientRect().height > 35)
          ) {
            this.hasBigContent = true;
            if (!!this.forum.autoUnfoldImportants
              && !!this.source.important
            ) {
              return;
            }
            if (!!this.forum.autoUnfoldCats
              && !!this.source.category
              && bbn.fn.isArray(this.forum.autoUnfoldCats)
              && this.forum.autoUnfoldCats.includes(this.source.category)
            ) {
              return;
            }
            this.foldContent();
          }
        }, 100)
      });
    }
  }
})();