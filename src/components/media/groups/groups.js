(() => {
  return {
    props: {
      /**
       * @prop {Boolean} [true] scrollable
       */
      scrollable: {
        type: Boolean,
        default: true
      },
      sourceUrl: {
        type: String,
        required: true
      },
      mediasUrl: {
        type: String,
        required: true
      },
      groupMediasUrl: {
        type: String,
        required: true
      },
      actionsUrl: {
        type: String,
        required: true
      },
      mediasUploadUrl: {
        type: String
      },
      mediasRemoveUrl: {
        type: String
      }
    },
    data(){
      return {
        current: false,
        search: '',
        listMounted: false
      }
    },
    methods: {
      create(){
        this.getPopup().open({
          title: bbn._('Create new medias group'),
          width: '300px',
          component: this.$options.components.form,
          source: {
            text: ''
          }
        });
      },
      rename(){
        this.getPopup().open({
          title: bbn._('Rename'),
          width: '300px',
          component: this.$options.components.form,
          source: this.current
        });
      },
      remove(){
        if (!!this.current && this.current.id) {
          this.confirm(bbn._('Are you sure you want to delete this medias group?'), () => {
            this.post(this.actionsUrl + 'delete', {id: this.current.id}, d => {
              if (d.success) {
                this.refresh();
                appui.success();
              }
            });
          });
        }
      },
      removeMedia(data){
        if (this.current
          && this.current.id
          && !!data.media
        ) {
          let post = () => {
            this.post(this.actionsUrl + 'remove', {
              idGroup: this.current.id,
              medias: bbn.fn.isArray(data.media) ? bbn.fn.map(data.media, m => m.id) : [data.media.id]
            }, d => {
              if (d.success) {
                this.getRef('mediaBrowser').refresh();
                appui.success();
              }
            });
          }
          if (!bbn.fn.isArray(data.media)) {
            this.confirm(bbn._('Are you sure you want to remove these medias from this group?'), post);
          }
          else {
            post();
          }
        }
      },
      refresh(){
        return this.getRef('list').updateData();
      },
      openAddMediaForm(){
        this.getPopup().open({
          width: '90%',
          height: '90%',
          title: bbn._('Select media(s)'),
          component: this.$options.components.addForm,
          source: {
            idGroup: this.current.id,
            medias: []
          }
        });
      }
    },
    mounted(){
      appui.register('appui-note-media-groups', this);
    },
    beforeDestroy() {
      appui.unregister('appui-note-media-groups');
    },
    watch: {
      current: {
        deep: true,
        handler(){
          this.$nextTick(() => {
            let mb = this.getRef('mediaBrowser');
            if (!!mb) {
              mb.refresh();
            }
          });
        }
      },
      search(val){
        let list = this.getRef('list').currentFilters.conditions;
        if (!val) {
          list.splice(0);
        }
        else {
          list.splice(0, list.length, {
            field: 'text',
            operator: 'contains',
            value: val
          });
        }
      }
    },
    components: {
      form: {
        template: `
<bbn-form :action="mainComponent.actionsUrl + (!!source.id ? 'rename' : 'create')"
          :source="source"
          @success="onSuccess">
  <div class="bbn-padded bbn-w-100">
    <bbn-input v-model="source.text"
               placeholder="` + bbn._('Name') + `"
               :required="true"
               class="bbn-w-100"/>
  </div>
</bbn-form>
        `,
        props: {
          source: {
            type: Object,
            required: true
          }
        },
        computed: {
          mainComponent(){
            return appui.getRegistered('appui-note-media-groups');
          }
        },
        methods: {
          onSuccess(d){
            if (d.success) {
              if (!this.source.id && !!d.data && d.data.id) {
                this.mainComponent.refresh().then(() => {
                  this.$nextTick(() => {
                    let list = this.mainComponent.getRef('list');
                    list.select(bbn.fn.search(list.filteredData, 'data.id', d.data.id));
                  });
                });
              }
              appui.success();
            }
            else {
              appui.error();
            }
          }
        }
      },
      addForm: {
        template: `
<appui-note-media-browser2 :source="mainComponent.mediasUrl"
                            @selection="onSelection"
                            @clickItem="onSelection"
                            :zoomable="false"
                            :limit="50"
                            path-name="path"
                            :upload="mainComponent.mediasUploadUrl"
                            :remove="mainComponent.mediasRemoveUrl"/>
        `,
        props: {
          source: {
            type: Object,
            required: true
          }
        },
        computed: {
          mainComponent(){
            return appui.getRegistered('appui-note-media-groups');
          }
        },
        methods: {
          onSelection(item){
            this.source.medias.splice(0);
            if (bbn.fn.isArray(item)) {
              bbn.fn.each(item, i => {
                if (i.id) {
                  this.source.medias.push(i.id);
                }
              });
            }
            else if (item.data && item.data.id) {
              this.source.medias.push(item.data.id);
            }
            if (this.source.medias.length) {
              this.post(this.mainComponent.actionsUrl + 'insert', this.source, d => {
                if (d.success) {
                  this.mainComponent.getRef('mediaBrowser').refresh();
                  this.getPopup().close();
                  appui.success();
                }
                else {
                  appui.error();
                }
              })
            }
          }
        }
      }
    }
  }
})();