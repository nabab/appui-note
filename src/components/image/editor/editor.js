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
            bbn.fn.log('beforeSave');
            //this.closest("bbn-floater").open(true);
            return {
              title: false,
              maxWidth: 1000,
              scrollable: true,
              closable: true,
              closeIcon: "bbn-white bbn-xxxl nf nf-mdi-close_circle",
              component: {
                template: `
            	<div class="bbn-bg-webblue bbn-w-100">
                <div class="bbn-xlpadding bbn-xxl bbn-block bbn-radius bbn-white">

                </div>
              </div>
            `,
                methods: {
                  close() {
                    this.closest("bbn-floater").close(true);
                  }
                },
                mounted() {
                  bbn.fn.log('modal mounted');
                }
              }
            };
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
  };
})();