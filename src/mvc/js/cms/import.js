// Javascript Document

(() => {
  return {
    name: 'appui-note-cms-import',
    data(){
      let processesList = [{
        text: bbn._("Select an XML file"),
        value: 'file'
      }, {
        text: bbn._("Read XML file"),
        value: 'read'
      }, {
        text: bbn._("Parse XML file"),
        value: 'parse'
      }, {
        text: bbn._("Make items"),
        value: 'make'
      }, {
        text: bbn._("Import medias"),
        value: 'medias'
      }, {
        text: bbn._("Import categories"),
        value: 'categories'
      }, {
        text: bbn._("Import tags"),
        value: 'tags'
      }, {
        text: bbn._("Import posts"),
        value: 'posts'
      }];
      return {
        root: appui.plugins['appui-note'] + '/',
        fileUploaded: !!this.source.cfg?.file ? [this.source.cfg.file] :  [],
        processesList: bbn.fn.map(processesList, p => {
          let c = this.source.cfg?.processes || {};
          c = c[p.value] || {};
          return bbn.fn.extend(p, {
            running: false,
            done: !!c.done,
            launchDate: c.launchDate || '',
            undoDate: c.undoDate || '',
            message: c.message || ''
          });
        })
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
              this.$set(this.source, 'cfg', {});
              bbn.fn.each(this.processesList, pro => {
                pro.done = false;
                pro.launchDate = '';
                pro.undoDate = '';
                pro.message = '';
              });
              appui.success();
            }
          });
        });
      },
      launchProcess(process){
        if (process) {
          process.running = true;
          bbn.fn.post(this.root + 'cms/import', {
            action: 'launch',
            file: this.currentFile,
            process: process.value
          }, d => {
            if (d.data?.message) {
              process.message = d.data.message;
            }
            else {
              process.message = '';
            }
            if (d.data?.success) {
              process.done = true;
            }
            process.running = false;
          })
        }
      },
      undoProcess(process){
        if (process) {
          bbn.fn.post(this.root + 'cms/import', {
            action: 'undo',
            file: this.currentFile,
            process: process.value
          }, d => {
            if (d.data?.message) {
              process.message = d.data.message;
            }
            else {
              process.message = '';
            }
            process.done = false;
          })
        }
      },
      formatDate(d){
        return !!d ? dayjs(d).format('DD/MM/YYYY HH:mm:ss') : '';
      }
    },
    created(){
      appui.register('appui-note-cms-import', this);
    },
    watch: {
      currentFile(newVal){
        bbn.fn.getRow(this.processesList, 'value', 'file').done = !!newVal;
      }
    },
    components: {
      processesListItem: {
        template: `
          <div :class="['bbn-flex-width', 'bbn-vmiddle', {'bbn-disabled': isDisabled}]">
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
          },
          list: {
            type: Array
          }
        },
        computed: {
          isDisabled(){
            const idx = bbn.fn.search(this.list, 'value', this.source.value);
            return !this.source.done
              && !this.source.running
              && !!this.list[idx-1]
              && !this.list[idx-1].done;
          }
        }
      }
    }
  }
})();
