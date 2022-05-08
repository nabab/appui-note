// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.inputComponent],
    props: {
      source: {
        type: Array,
        default() {
          return [];
        }
      }
    },
    data() {
      return {
	      root: appui.plugins['appui-note'] + '/',
        overImg: null
      };
    },
    computed: {
      currentIndex() {
        if (this.value) {
          return bbn.fn.search(this.source, {id: this.value});
        }

        return -1;
      }
    },
    methods: {
      openInfo(media) {
        this.getPopup({
          component: 'appui-note-media-info',
          source: media,
          title: false
        });
      },
      openGallery(){
        this.getPopup({
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
        this.emitInput(img.data.id);
        if (!bbn.fn.getRow(this.source, {id: img.data.id})) {
          bbn.fn.log(img.data);
          this.source.push(img.data);
        }
        this.getPopup().close();
      }
    },
    components: {
      gallery: {
        template: `
<div>
  <appui-note-media-browser2 :source="root + '/media/data/browser'"
                             @selection="onSelection"
                             @clickItem="onSelection"
                             :zoomable="false"
                             :selection="false"
                             :limit="50"
                             path-name="path"
                             :upload="root + 'media/actions/upload'"
                             :remove="root + 'media/actions/remove'"/>
</div>
        `,
        methods: {
          onSelection() {
            this.closest('bbn-floater').opener.onSelection(...arguments);
          }
        },
        data(){
          return {
            root: appui.plugins['appui-note'] + '/'
          };
        }
      }
    }
  };
})();