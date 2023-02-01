// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: {
      config: {
        type: Object
      }
    },
    data() {
      return {
        defaultConfig: {
          content: '',
          alt: '',
          href: '',
          caption: '',
          details_title: '',
          details: '',
          width: '100%',
          height: '100%',
          align: 'center'
        }
      };
    },
    computed: {
      align(){
        let style = {};
        switch (this.source.align) {
          case 'left':
            style.justifyContent = 'flex-start';
            break;
          case 'center':
            style.justifyContent = 'center';
            break;
          case 'right':
            style.justifyContent = 'flex-end';
            break;
        }
        return style;
      }
    },
    methods: {
      openGallery(){
        this.getPopup().open({
          component: this.$options.components.gallery,
          componentOptions: {
            onSelection: this.onSelection
          },
          title: bbn._('Select an image'),
          width: '90%',
          height: '90%'
        });
      },
      onSelection(img) {
        this.source.source = img.data.path;
        this.getPopup().close();
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