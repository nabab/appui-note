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
        config: {
          source: this.source,
          onBeforeSave: () => {
            this.getPopup({
              title: false,
              maxwidth: 1000,
              closable: true,
              closeIcon: "bbn-black bbn-xxl nf nf-mdi-close_circle",
              component: "appui-note-image-form"
            });
            return false;
          },
          onSave: (imageData, designState) => {
            this.$emit('save', imageData, designState);
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
      }
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