// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    data(){
      return {
        disableHeight: false,
        ratios: [{
          text: '1:1',
          value: '1/1'
        },{
          text: '16:9',
          value: '16/9'
        },{
          text: '4:3',
          value: '4/3'
        },{
          text: '3:2',
          value: '3/2'
        },{
          text: '8:5',
          value: '8/5'
        }
      ]

      }
    },
    methods:{
      isNull: bbn.fn.isNull
      
    },
    computed: {
      youtube(){
        let reg = /^https?:\/\/w{0,3}\.?youtu\.?be(-nocookie)?(\.com)?\//gm;
        return this.source.source.search(reg) > -1;
      },
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
      }, 
      width(){
        return 'min(100%, ' + this.source.style.width + ')'
      }
    },
    watch: {
      'source.aspectRatio'(val){
        console.log('watch aspect ratio')
        if(val){
          this.disableHeight = true;
          this.source.style.height = 'auto';
        }
        else{
          this.disableHeight = false;
        }
      }
    },
    beforeMount(){
      if(this.source.aspectRatio){
        this.disableHeight = true;
        this.source.style.height = 'auto'
      }
    }
  };
})();