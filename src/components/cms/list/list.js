// Javascript Document// Javascript Document
(() => {
  let componentName;
  let root = appui.plugins['appui-note'] + '/';

  return {
    mixins: [bbn.vue.basicComponent],
    props: {
      noteName: {
        type:String,
        default: bbn._("Note")
      },
      types: {
        type: Array,
        required: true,
      },
      columns: {
        type: Array,
        default() {
          return [];
        }
      },
      url: {
        type: String,
        default: root + 'cms/list'
      },
      previewUrl: {
      	type: String,
        default: root + 'cms/preview/'
      },
      mediaUrl: {
        type: String,
        default: root + '/cms/actions/add_media'
      },
      publishUrl: {
        type: String,
        default: root + 'cms/actions/publish'
      },
      unpublishUrl: {
        type: String,
        default: root + 'cms/actions/unpublish'
      },
      insertUrl: {
        type: String,
        default: root + 'cms/actions/insert'
      },
      deleteUrl: {
        type: String,
        default: root + 'cms/actions/delete'
      },
      editorUrl: {
        type: String,
        default: root + 'cms/editor/'
      },
      publishComponent: {
        type: [String, Vue],
        default: 'appui-note-cms-form-publish'
      },
      insertComponent: {
        type: [String, Vue],
        default: 'appui-note-cms-form-insert'
      },
      root: {
        type: [String],
        default: root
      },
      actions: {
        type: [Array, Function]
      }
    },
    data(){
      return {
        users: appui.app.users
      };
    },
    methods: {
      isPublished(row) {
        if (row.start) {
          let now = bbn.fn.dateSQL();
          if (!row.end || (row.end > now)) {
            return true;
          }
        }

        return false;
      },
      rowMenu(row, col, idx){
        return [{
          action: () => {
            this.editNote(row);
          },
          icon: 'nf nf-fa-edit',
          text: bbn._("Edit"),
          key: 'a'
        }, {
          action: () => {
            this.publishNote(row);
          },
          icon: 'nf nf-fa-chain',
          text: bbn._("Publish"),
          disabled: this.isPublished(row),
          key: 'b'
        }, {
          action: () => {
            this.unpublishNote(row);
          },
          icon: 'nf nf-fa-chain_broken',
          text: bbn._("Unpublish"),
          disabled: !this.isPublished(row),
          key: 'c'
        }, {
          action: () => {
            this.deleteNote(row);
          },
          text: bbn._("Delete"),
          icon: 'nf nf-fa-trash_o',
          key: 'e'
        }];
      },
      //Methods call of the menu in toolbar
      //FILE
      insertNote(){
        this.getPopup({
          width: 800,
          title: bbn._('New') + ' ' + this.noteName,
          component: this.insertComponent,
          componentOptions: {
            source: {
              url: this.insertUrl,
            },
            types: this.types
          }
        });
      },
      // methods each row of the table
      editNote(row){
        bbn.fn.link(this.editorUrl + row.id_note);
      },
      publishNote(row){
        let src =  bbn.fn.extend(row, {
          action: this.publishUrl
        });

        this.getPopup().open({
          width: '100%',
          title: false,
          scrollable: false,
          source: src,
          modal: true,
          component: this.publishComponent,
          componentOptions: {
            url: this.publishUrl,
            list: this.getRef('table'),
            source: src
          }
        });
      },
      unpublishNote(row){
        appui.confirm(bbn._('Are you sure you want to cease the publication of this note?'), () => {
          bbn.fn.post(this.unpublishUrl,{id: row.id_note }, d =>{
            if ( d.success ){
              this.getRef('table').reload();
              appui.success(bbn._('Successfully removed from publications'));
            }
            else{
              appui.error(bbn._('Error in this action'));
            }
          });
        });
      },
      deleteNote(row){
        appui.confirm(bbn._('Are you sure to delete this note?'), () => {
          bbn.fn.post(this.deleteUrl, {id: row.id_note }, (d) =>{
            if ( d.success ){
              this.getRef('table').reload();
              appui.success(bbn._('Successfully deleted'));
            }
            else{
              appui.error(bbn._('Error in deleting'));
            }
          });
        });
      },
      //SHOW
      filterTable(type){
        let table = this.getRef('table'),
            idx = bbn.fn.search(table.currentFilters.conditions, 'field', 'type');
        if ( idx > -1 ){
          table.$set(table.currentFilters.conditions[idx], 'value', type);
        }
        else {
          table.currentFilters.conditions.push({
            field: 'type',
            value: type
          });
        }
      },
      // function of render
      renderUrl(row){
        if (row.url !== null) {
          return '<a href="' + this.previewUrl + row.url + '" target="_blank">' + row.url + '</a>';
        }

        return '-';
      },
    },
    created(){
      appui.register('appuiCmsList', this);
    },
    beforeDestroy(){
      appui.unregister('appuiCmsList');
    },
    components: {
      browser :{
        props: ['source'],
        template: '<appui-note-media-browser @select="insertMedia" :select="true"></appui-note-media-browser>',
        data(){
          return {
            root: this.closest('bbn-container').getComponent().root
          }
        },
        computed:{
          selected(){
            return this.find('appui-note-media-browser').selected
          }
        },
        methods: {
          insertMedia(m){
            m.extension = '.' + m.content.extension
            /*if (m.content){
              m.content = JSON.stringify(m.content)
            }*/
            //case inserting media during update
						if ( this.source.id_note ){
              this.post(this.mediaUrl, {
                id_note: this.source.id_note,
                id_media: m.id,
                version: this.source.version
              }, (d) => {
                if ( d.success ){
                  this.source.files.push(m)
                  appui.success(bbn._('Media correctly added to the note'));
                }
                else {
                  appui.success(bbn._('Something went wrong while adding the media to the note'));
                }
              })
            }
            //case adding media while inserting note
						else{
              this.source.files.push(m)
            }
            this.closest('bbn-popup').close()
          }
        },
      },
      toolbar: {
        template: `
  <bbn-toolbar class="bbn-header bbn-hspadded bbn-h-100 bg-colored">
    <div class="bbn-flex-width">
      <bbn-button icon="nf nf-fa-plus"
                  :text="_('Insert Articles')"
                  :action="insertNote"
      ></bbn-button>
      <div class="bbn-xl bbn-b bbn-flex-fill bbn-r bbn-white">
        <?=_("The Content Management System")?>
      </div>
    </div>
  </bbn-toolbar>`,
        props: ['source'],
        data(){
          return {
            cp: appui.getRegistered('appuiCmsList'),
          }
        },
        methods:{
          insertNote(){
            return this.cp.insertNote();
          }
        }
      },
    }
  }
})();