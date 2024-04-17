(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-note-cms-block']],
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
        this.getPopup({
          component: this.$options.components.browser,
          source: file,
          title: bbn._('Select a media'),
          width: '90%',
          height: '90%'
        });
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
          bbn.fn.download(appui.plugins['appui-note'] + '/media/download/' + file.value);
        }
        else {
          window.open(file.value);
        }
      }
    },
    components: {
      browser: {
        template: `
<div>
  <appui-note-media-browser :source="root + 'media/data/browser'"
                             @selection="onSelection"
                             @clickitem="onSelection"
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
        mixins: [bbn.cp.mixins.basic],
        props: {
          source: {
            type: Object,
            required: true
          }
        },
        data(){
          return {
            root: appui.plugins['appui-note'] + '/'
          }
        },
        methods: {
          onSelection(media) {
            this.$set(this.source, 'value', media.data.id);
            this.$set(this.source, 'text', media.data.name);
            this.$set(this.source, 'filename', media.data.name);
            this.getPopup().close();
          },
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