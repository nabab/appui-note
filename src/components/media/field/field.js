// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins.input],
    props: {
      source: {
        type: Array
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
          label: false
        });
      },
      openGallery(){
        this.getPopup({
          component: this.$options.components.browser,
          source: this.source,
          label: bbn._('Select an image'),
          width: '90%',
          height: '90%'
        });
      },
      showImage(img) {
        if (!img && (this.currentIndex === -1)) {
          return;
        }
        if (!img) {
          img = this.source[this.currentIndex];
        }

        appui.getPopup({
          label: false,
          component: this.$options.components.viewer,
          componentOptions: {source: img},
          width: '100%',
          modal: true,
          height: '100%',
          closable: true,
          scrollable: false
        })
      },
      onSelection(img) {
        if (!bbn.fn.getRow(this.source, {id: img.data.id})) {
          this.source.push(img.data);
        }
        this.emitInput(img.data.id);
        this.getPopup().close();
      }
    },
    components: {
      viewer: {
        template: `
<div class="bbn-overlay bbn-middle"
     @click="close">
	<img :src="root +  '/media/image/' + source.id"
       style="max-width: 100%; max-height: 100%; width: auto; height: auto"
       @click.stop>
</div>`,
        props: ['source'],
        data() {
          return {
            root: appui.plugins['appui-note'] + '/'
          };
        },
        methods: {
          close() {
            this.closest('bbn-floater').close();
          }
        }
      },
      browser: {
        template: `
<div>
  <appui-note-media-browser :source="root + '/media/data/browser'"
                             @selection="onSelection"
                             @clickitem="onSelection"
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
        mixins: [bbn.cp.mixins.basic],
        data(){
          return {
            root: appui.plugins['appui-note'] + '/'
          };
        },
        methods: {
          onSelection(media) {
            this.closest('bbn-floater').opener.onSelection(media);
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
  };
})();