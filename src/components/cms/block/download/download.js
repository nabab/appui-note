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
        bbn.fn.log('seelected', media)
        this.$set(file, 'value', media.data.path);
        this.$set(file, 'text', media.data.name);
        this.$set(file, 'filename', media.data.name);
        this.getPopup().close();
      },
      onChangeType(file){
        bbn.fn.log('aaaa', file)
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
                             :remove="root + 'media/actions/remove'"/>
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
        }
      }
    }
  }
})();