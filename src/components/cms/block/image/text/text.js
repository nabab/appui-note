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