(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data() {
      let obj = {
        type: 'media',
        text: '',
        value: ''
      };
      return {
        emptyObj: obj,
        defaultConfig: {
          content: [bbn.fn.clone(obj)],
          orientation: 'vertical'
        },
        types: [{
          text: bbn._('Media'),
          value: 'media'
        }, {
          text: bbn._('URL'),
          value: 'url'
        }]
      };
    },
    computed: {
      currentStyle(){
        return {
          flexDirection: this.source.orientation === 'vertical' ? 'column' : 'row',
          gridGap: 'var(--sspace)'
        };
      }
    },
    methods: {
      addItem(){
        this.source.content.push(bbn.fn.clone(this.emptyObj));
      },
      removeItem(idx){
        this.confirm(bbn._('Are you sure you want to remove this file?'), () => {
          this.source.content.splice(idx, 1);
        });
      },
      openExplorer(file){
        this.getPopup().open({
          component: this.$options.components.gallery,
          componentOptions: {
            onSelection: media => this.onSelection(media, file)
          },
          title: bbn._('Select a media'),
          width: '90%',
          height: '90%'
        });
      },
      onSelection(media, file) {
        this.$set(file, 'value', media.data.path);
        this.$set(file, 'text', media.data.name);
        this.$set(file, 'filename', media.data.name);
        this.getPopup().close();
      },
      onChangeType(file){
        this.$set(file, 'value', '');
        this.$set(file, 'text', '');
        if (file.type === 'url') {
          this.$delete(file, 'filename');
        }
      },
      onDownload(file){
        if (file.type === 'media') {
          bbn.fn.download(file.value);
        }
        else {
          bbn.fn.link(file.value);
        }
      }
    },
    components: {
      gallery: {
        template: `
<div>
  <appui-note-media-browser2 :source="root + 'media/data/browser'"
                             @selection="onSelection"
                             @clickItem="onSelection"
                             :zoomable="false"
                             :selection="false"
                             :limit="50"
                             path-name="path"
                             :upload="root + 'media/actions/save'"
                             :remove="root + 'media/actions/delete'"
                             overlay-name="name"
                             @delete="onDelete"
                             ref="mediabrowser"/>
</div>
        `,
        props: {
          onSelection: {
            type: Function
          }
        },
        data(){
          return {
            root: appui.plugins['appui-note'] + '/'
          }
        },
        methods: {
          onDelete(obj){
            let id = bbn.fn.isArray(obj.media) ? bbn.fn.map(obj.media, m => m.id) : (obj.media.id || false);
            this.post(this.root + 'media/actions/delete', {id: id}, d => {
              if (d.success) {
                this.getRef('mediabrowser').refresh();
                appui.success();
              }
              else {
                appui.error();
              }
            });
          }
        }
      }
    }
  }
})();