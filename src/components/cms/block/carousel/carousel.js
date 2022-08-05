// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data(){
      return {
        currentIndex: false,
        slideshowSourceUrl: appui.plugins['appui-note'] + '/media/data/groups/medias',
        currentItems: [],
        galleryListUrl: appui.plugins['appui-note'] + '/media/data/groups/list',
        arrowsPositions: [{
          text: bbn._('Default'),
          value: 'default'
        }, {
          text: bbn._('Top'),
          value: 'top'
        }, {
          text: bbn._('Top-Left'),
          value: 'topleft'
        }, {
          text: bbn._('Top-Right'),
          value: 'topright'
        }, {
          text: bbn._('Bottom'),
          value: 'bottom'
        }, {
          text: bbn._('Bottom-Left'),
          value: 'bottomleft'
        }, {
          text: bbn._('Bottom-Right'),
          value: 'bottomright'
        }]
      }
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
      getCurrentIndex(){
        this.$nextTick(()=>{
          this.currentIndex = this.$refs.slideshow.currentIndex;
        })
        
      },
      requestFullScreen(){
				if(document.fullscreenEnabled && this.img){
          this.$nextTick(()=>{
            if (this.img.requestFullscreen) {
              this.img.requestFullscreen();
            } else if (this.img.webkitRequestFullscreen) { /* Safari */
              this.img.webkitRequestFullscreen();
            } else if (this.img.msRequestFullscreen) { /* IE11 */
              this.img.msRequestFullscreen();
            }
          })
					
				}
			},
      openMediasGroups(){
        this.getPopup().load({
          title: bbn._('Medias Groups Management'),
          url: appui.plugins['appui-note'] + '/media/groups',
          width: '90%',
          height: '90%',
          onClose: () => {
            this.getRef('galleryList').updateData();
          }
        });
      },
      updateData(){
        if (this.source.source) {
          this.post(this.slideshowSourceUrl, {data: {idGroup: this.source.source}}, d => {
            if (d.success && d.data) {
              this.currentItems.splice(0, this.currentItems.length);
              this.$nextTick(() => {
                this.currentItems.push(...bbn.fn.map(d.data, data => {
                  data.type = 'img';
                  data.content = data.path;
                  data.mode = 'full';
                  data.info = data.title;
                  return data;
                }));
              });
            }
          });
        }
      }
    },
    beforeMount(){
      this.updateData();
    },
    watch: {
      currentIndex(val){
        this.$nextTick(() => {
          if(this.img){
            this.img.removeEventListener("click", this.requestFullScreen, false);
          }
          this.img =  this.$el.querySelector('.img' + val);
          if(this.img){
            this.img.classList.add('bbn-p')
            this.img.addEventListener("click", this.requestFullScreen, false);
          }
        })
        
      },
      'source.source'(){
        this.updateData();
      }
    }
  }
})();