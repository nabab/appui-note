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
        this.$set(this.source, 'content', img.data.path);
        this.getPopup().close();
      },
      toggleAutoWidth(){
        let isActive = (this.source.width === 'auto') || (this.source.width === '') || (this.source.width === undefined);
        this.$set(this.source, 'width', isActive ? '10' + this.getRef('widthRange').currentUnit : 'auto');
      },
      toggleAutoHeight(){
        let isActive = (this.source.height === 'auto') || (this.source.height === '') || (this.source.height === undefined);
        this.$set(this.source, 'height', isActive ? '10' + this.getRef('heightRange').currentUnit : 'auto');
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
                             ref="mediabrowser"
                             @delete="onDelete"/>
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