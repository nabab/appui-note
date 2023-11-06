// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.mixins['appui-note-cms-block']],
    props: {
      config: {
        type: Object
      }
    },
    data(){
      return {
        defaultConfig: {
          content: "",
          autoplay: 0,
          muted: 0,
          controls: 0,
          loop: 0,
          width: '100%',
          height: '100%',
          align: 'center'
        },
        aspectRatio: null,
        disableHeight: false,
        ratios: [{
          text: bbn._('None'),
          value: ''
        }, {
          text: '1:1',
          value: '1/1'
        }, {
          text: '16:9',
          value: '16/9'
        }, {
          text: '4:3',
          value: '4/3'
        }, {
          text: '3:2',
          value: '3/2'
        }, {
          text: '8:5',
          value: '8/5'
        }]
      }
    },
    methods:{
      isNull: bbn.fn.isNull
    },
    computed: {
      youtube(){
        let reg = /^https?:\/\/w{0,3}\.?youtu\.?be(-nocookie)?(\.com)?\//gm;
        return this.source.content?.search(reg) > -1;
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
        return 'min(100%, ' + this.source.width + ')'
      }
    },
    watch: {
      'source.aspectRatio'(val){
        if(val){
          this.disableHeight = true;
          this.source.height = 'auto';
          this.aspectRatio = this.source.aspectRatio;
        }
        else{
          this.aspectRatio = undefined;

          this.disableHeight = false;
        }
      }
    },
    beforeMount(){
      if(this.source.aspectRatio){
        this.aspectRatio = this.source.aspectRatio;
        this.disableHeight = true;
        this.source.height = 'auto'
      }
    }
  };
})();