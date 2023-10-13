// Javascript Document

(() => {
  return {
    name: 'appui-note-cms-import',
    data(){
      return {
        selectedProcess: null,
        infoMessage: null,
        message: null,
        lastLaunch: null,
        lastUndo: null,
        cfg: this.source.cfg || {},
        root: appui.plugins['appui-note'] + '/',
        fileUploaded: !!this.source.cfg?.file ? [this.source.cfg.file] :  [],
        processList: [{
          text: bbn._("Select an XML file"),
          value: 'file',
          done: !!this.source.cfg?.file,
          running: false
        }, {
          text: bbn._("Read XML file"),
          value: 'parse',
          done: false,
          running: false
        }, {
          text: bbn._("Parse XML file"),
          value: 'parse',
          done: false,
          running: false
        }],
        runningProcess: false
      }
    },
    computed: {
      currentFile(){
        return this.fileUploaded.length ? this.fileUploaded[0] : null;
      }
    },
    methods: {
      reset(){
        this.confirm(bbn._("Are you sure you want to reset the import process?"), () => {
          bbn.fn.post(this.root + 'cms/import', {
            action: 'reset'
          }, d => {
            if (d.success) {
              this.fileUploaded.splice(0);
              this.getRef('uploader').currentData.splice(0);
              appui.success();
            }
          });
        });
      },
      launchProcess(){
        if (this.selectedProcess) {
          bbn.fn.post(this.root + 'cms/import', {
            action: 'launch',
            file: this.currentFile,
            process: this.selectedProcess
          }, d => {
            if (d.data?.message) {
              this.message = d.data.message;
            }
            else {
              this.message = '';
            }
          })
        }
      },
      undoProcess(){
        if (this.selectedProcess) {
          bbn.fn.post(this.root + 'cms/import', {
            action: 'undo',
            file: this.currentFile,
            process: this.selectedProcess
          }, d => {
            if (d.data?.message) {
              this.message = d.data.message;
            }
            else {
              this.message = '';
            }
          })
        }
      },
      selectProcess(val){
        this.selectedProcess = val.text;
      }
    },
    created(){
      appui.register('appui-note-cms-import', this);
    },
    watch: {
      selectedProcess(v) {
        bbn.fn.post(this.root + 'cms/import', {
          process: v,
          file: this.currentFile,
          action: 'info'
        }, d => {
          this.message = '';
          this.infoMessage = d.lastMessage || '';
          this.lastLaunch = d.lastLaunch || '';
          this.lastUndo = d.lastUndo || '';
        })
      },
      currentFile(newVal){
        bbn.fn.getRow(this.processList, 'value', 'file').done = !!newVal;
      }
    },
    components: {
      processListItem: {
        template: `
          <div :class="['bbn-flex-width', 'bbn-vmiddle', {'bbn-disabled': !source.done && !source.running}]">
            <i :class="['bbn-m', {
                 'nf nf-md-check_circle bbn-green': !!source.done,
                 'nf nf-md-play_circle bbn-blue': !!source.running,
                 'nf nf-md-dots_circle': !source.done && !source.running
               }]"/>
            <div class="bbn-flex-fill bbn-left-sspace"
                 v-text="source.text"/>
          </div>
        `,
        props: {
          source: {
            type: Object
          }
        }
      }
    }
  }
})()