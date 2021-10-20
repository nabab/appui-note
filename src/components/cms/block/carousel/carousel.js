// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data(){
      return {
        slideshowSourceUrl: appui.plugins['appui-note'] + '/media/data/groups/medias',
        currentItems: [],
        units: [{
          text: '%',
          value: '%'
        }, {
          text: 'px',
          value: 'px'
        }, {
          text: 'em',
          value: 'em'
        }],
        currentWidth: this.source.style.width,
        currentWidthUnit: '%',
        currentHeight: this.source.style.height,
        currentHeightUnit: 'px'
      }
    },
    computed: {
      galleries(){
        let cp = this.closest('appui-note-cms-editor');
        if (cp && !!cp.source.mediasGroups) {
          return bbn.fn.order(bbn.fn.map(cp.source.mediasGroups, mg => {
            return {
              text: mg.text,
              value: mg.id
            };
          }), 'text', 'asc');
        }
        return [];
      },
    },
    methods: {
      openMediasGroups(){
        this.getPopup().load({
          title: bbn._('Medias Groups Management'),
          url: appui.plugins['appui-note'] + '/media/groups',
          width: '90%',
          height: '90%'
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
      'source.source'(){
        this.updateData();
      },
      currentWidth(val){
        this.source.style.width = this.currentWidth;
      },
      currentWidthUnit(val){
        this.source.style.width = this.currentWidth + this.currentWidthUnit;
      },
      currentHeight(val){
        this.source.style.height = this.currentHeight;
      },
      currentHeightUnit(val){
        this.source.style.height = this.currentHeight + this.currentHeightUnit;
      }
    }
  }
})();