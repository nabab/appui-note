// Javascript Document

(() => {
  return {
    data(){
      return {
        processList: this.source.filesList,
        selectedProcess: null,
        infoMessage: null,
        message: null,
        lastLaunch: null,
        lastUndo: null,
        root: appui.plugins['appui-note'] + '/',
        fileUploaded: []
      }
    },
    computed: {
      currentFile(){
        return this.fileUploaded.length ? this.fileUploaded[0].name : ''
      }
    },
    methods: {
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
      }
    }
  }
})()