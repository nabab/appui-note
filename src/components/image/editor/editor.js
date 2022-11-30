// Javascript Document

(() => {
  return {
    mixins:
    [
      bbn.vue.basicComponent,
      bbn.vue.eventsComponent,
      bbn.vue.resizerComponent
    ],
    props: {
      source: {
        type: String,
        default: ""
      }
    },
    data() {
      return {
        widget: null,
        showFloater: false,
        img: null,
        config: {
          source: this.source,
          onBeforeSave: (imageFileInfo) => {
            this.img = this.widget.config.getCurrentImgDataFnRef.current();
            this.showFloater = true;
            return false;
          },
          onSave: () => {
            bbn.fn.log('onSave');
          },
          annotationsCommon: {
            fill: '#ff0000'
          },
          Text: { text: 'Filerobot...' },
          tabsIds: [window.FilerobotImageEditor.TABS.ADJUST,window.FilerobotImageEditor.TABS.ANNOTATE,window.FilerobotImageEditor.TABS.WATERMARK],
          defaultTabId: window.FilerobotImageEditor.TABS.ANNOTATE,
          defaultToolId: window.FilerobotImageEditor.TOOLS.TEXT,
        }
      };
    },
    methods: {
      init() {
        this.widget = new FilerobotImageEditor(
          this.$el.querySelector('.editor_container'),
          this.config
        );
        this.widget.render({
          onClose: (closingReason) => {
            console.log('Closing reason', closingReason);
            window.FilerobotImageEditor.terminate();
          }
        });
      },
      close() {
        this.showFloater = false;
      },
      saveInfo(data) {
        if ((data.width != this.img.imageData.width) || (data.height != this.img.imageData.height)) {
          let img = new Image();
          img.onload = function() {
            let canva = document.createElement('canvas');
        		let ctx = canva.getContext('2d');
           	canva.width = data.width;
    				canva.height = data.height;
            ctx.drawImage(img, 0, 0, canva.width, canva.height);
            ctx.drawImage(canva, 0, 0, canva.width, canva.height);
          };
          img.src = this.img.imageData.imageBase64;
          this.img.imageData.imageBase64 = img;
        }
        this.$emit('save', this.img.imageData);
      },
    },
    mounted() {
      let scriptRobot = document.getElementById('script_robot');
      if (!scriptRobot) {
        scriptRobot = document.createElement('script');
        scriptRobot.onload = () => {
          this.init();
        };
        scriptRobot.setAttribute('src', 'https://scaleflex.cloudimg.io/v7/plugins/filerobot-image-editor/latest/filerobot-image-editor.min.js');
        scriptRobot.setAttribute('id', 'script_robot');
        document.head.appendChild(scriptRobot);
      }
      else {
        this.init();
      }
    }
  };
})();