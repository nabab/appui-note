(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
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
      },
      mediasDetailUrl: {
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
        this.getPopup({
          label: bbn._('Create new medias group'),
          width: '300px',
          component: this.$options.components.form,
          source: {
            text: ''
          }
        });
      },
      rename(){
        this.getPopup({
          label: bbn._('Rename'),
          width: '300px',
          component: this.$options.components.form,
          source: this.current
        });
      },
      removeItem(){
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
        this.getPopup({
          width: '90%',
          height: '90%',
          label: bbn._('Select media(s)'),
          component: this.$options.components.addForm,
          source: {
            idGroup: this.current.id,
            medias: []
          }
        });
      },
      sort(ev, ids){
        if (this.current && this.current.id && bbn.fn.numProperties(ids)) {
          this.post(appui.plugins['appui-note'] + '/media/actions/groups/order', {
            idGroup: this.current.id,
            idMedias: ids
          }, d => {
            if (d.success) {
              appui.success();
            }
            else {
              ev.preventDefault();
              appui.error();
            }
          });
        }
        else {
          ev.preventDefault();
          appui.error();
        }
      },
      insertLink(a){
        console.log(a)
        this.getPopup({
          label: a.data.link ? bbn._('Edit Link') : bbn._('Insert Link'),
          width: '300px',
          component: this.$options.components.formLink,
          source: a.data
        });
      }
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
      formLink: {
        template: `
<bbn-form :action="mainComponent.actionsUrl + (!!source.id ? 'link/update' : 'link/insert')"
          :source="source"
          @success="onSuccess"
          :data="{
            id_group: mainComponent.current.id
          }">
  <div class="bbn-padding bbn-w-100 bbn-grid-fields">
    <bbn-search source-text="title"
                component="appui-note-search-item"
                source-url=""
                :placeholder="placeholder"
                @select="select"
                :source="note + '/cms/data/search'"
                class="bbn-w-100"/>
    <i class="nf nf-fa-close bbn-m bbn-p"
       bbn-if="source.link"
       @click="source.link = ''"
    />
  </div>
</bbn-form>
        `,
        props: {
          source: {
            type: Object,
            required: true
          }
        },
        data(){
          return {
            note: appui.plugins['appui-note'],
            mainComponent: this.closest('bbn-popup').find('appui-note-media-groups')
          }
        },
        computed: {
          placeholder(){
            if(this.source.link){
              return this.source.link
            }

            return bbn._('Pick a link')
          }
        },
        methods: {
          select(a){
            this.source.link = a.url;
          },
          onSuccess(d){
            if(d.success){
              appui.success(bbn._('Link saved'));
            }
          }
        }
      },
      form: {
        template: `
<bbn-form :action="mainComponent.actionsUrl + (!!source.id ? 'rename' : 'create')"
          :source="source"
          @success="onSuccess">
  <div class="bbn-padding bbn-w-100">
    <bbn-input bbn-model="source.text"
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
        data(){
          return {
            mainComponent: this.closest('bbn-popup').find('appui-note-media-groups')
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
<appui-note-media-browser :source="mainComponent.mediasUrl"
                            @selection="onSelection"
                            @clickitem="onSelection"
                            :zoomable="false"
                            :limit="50"
                            path-name="path"
                            :upload="mainComponent.mediasUploadUrl"
                            :removed="mainComponent.mediasRemoveUrl"/>
        `,
        mixins: [bbn.cp.mixins.basic],
        props: {
          source: {
            type: Object,
            required: true
          }
        },
        data(){
          return {
            mainComponent: this.closest('bbn-popup').find('appui-note-media-groups')
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