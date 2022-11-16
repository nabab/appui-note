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
        config: {
          source: this.source,
          onSave: (imageData, designState) => {
          	this.$emit('onsave', imageData, designState);
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
    created() {
      let scriptRobot = document.getElementById('script_robot');
      if (!scriptRobot) {
        scriptRobot = document.createElement('script');
        scriptRobot.setAttribute('src', 'https://scaleflex.cloudimg.io/v7/plugins/filerobot-image-editor/latest/filerobot-image-editor.min.js');
        scriptRobot.setAttribute('id', 'script_robot');
        document.head.appendChild(scriptRobot);
      }
    },
    mounted() {
      const editor = new FilerobotImageEditor(
        this.$el.querySelector('.editor_container'),
        this.config
      );
      editor.render({
        onClose: (closingReason) => {
          console.log('Closing reason', closingReason);
          window.FilerobotImageEditor.terminate();
        }
      });
    }
  };
})();