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
          source: this.source + '?t=' + bbn.fn.timestamp(),
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
        if ((data.width != this.img.imageData.width) || (data.height != this.img.imageData.height) || (data.extension != this.img.imageData.extension)) {
          let new_img = new Image();
          new_img.onload = () => {
          	let canvas = document.createElement('canvas');
            let ctx = canvas.getContext('2d');
            canvas.width = data.width;
            canvas.height = data.height;
            if (data.extension == 'jpg' || data.extension == 'jpeg') {
              ctx.fillStyle = "#fff";
              ctx.fillRect(0, 0, canvas.width, canvas.height);
            }
            ctx.drawImage(new_img, 0, 0, canvas.width, canvas.height);
            let dataURI = data.extension == 'jpg' ? canvas.toDataURL("image/jpeg") : canvas.toDataURL("image/" + data.extension);
            this.img.imageData.imageBase64 = dataURI;
            this.img.imageData.imageCanvas = canvas;
            this.img.imageData.height = parseInt(data.height);
            this.img.imageData.width = parseInt(data.width);
            this.img.imageData.extension = data.extension;
            this.img.imageData.name = data.name;
            this.img.imageData.fullName = data.name + '.' + data.extension;
            this.img.imageData.mimeType = data.extension == 'jpg' ? "image/jpeg" : "image/" + data.extension;
            this.$emit('save', this.img.imageData);
          };
          new_img.src = this.img.imageData.imageBase64;
        }
        else {
          this.img.imageData.name = data.name;
        	this.$emit('save', this.img.imageData);
        }
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