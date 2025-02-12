// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-note-cms-block']],
    data(){
      return {
        
      }
    },
    computed: {
      sizeClass(){
        let st = 'bbn-w-';
        st += Math.floor(100/this.source.elements);
        return st;
      },
      mobileSizeClass(){
				let st = 'bbn-mobile-w-';
        st += Math.floor(100/this.source.mobileElements);
        return st;
      },
      align(){
        let style = {};
        style['text-align'] = this.source.align
        
        return style;
      }
    },
    methods: {
	  	selectDesktopGrid(a){
        this.source.elements = a[1]
      },
      selectMobileGrid(a){
        this.source.mobileElements = a[1]
      },
      openGallery(){
        this.getPopup({
          component: this.$options.components.gallery,
          componentOptions: {
            onSelection: this.onSelection
          },
          label: bbn._('Select an image'),
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
  <appui-note-media-browser :source="root + 'media/data/browser'"
                             @selection="onSelection"
                             @clickitem="onSelection"
                             :zoomable="false"
                             :selection="false"
                             :limit="50"
                             path-name="path"
                             :upload="root + 'media/actions/save'"
                             :removed="root + 'media/actions/delete'"
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
    },

    beforeMount(){
      this.source.elements = 3;
      this.source.mobileElements = 1;
        if(this.mode === 'read'){
          this.closest('appui-note-cms-block').currentClass = this.mobileSizeClass + ' ' +this.sizeClass;
      }
    },


  }
})();