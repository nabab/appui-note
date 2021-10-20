// Javascript Document// Javascript Document
(() => {
  return {
    mixins: [bbn.vue.basicComponent],
    props: {
      source: {
        type: Object
      },
      noteName: {
        type:String,
        default: bbn._("Note")
      },
      types: {
        required: true,
        type: Array
      }
    },
    data(){
      return {
        root: appui.plugins['appui-note'] + '/',
        //for table note
        users: appui.app.users
      };
    },
    methods: {
      //Methods call of the menu in toolbar
      //FILE
      insertNote(){
        this.getPopup({
          width: 800,
          title: bbn._('New') + ' ' + this.noteName,
          component: this.getComponentName('../new'),
          componentOptions: {
            source: {
              url: this.root + 'cms/actions/insert',
            },
            types: this.types
          }
        });
      },
      // methods each row of the table
      editNote(row){
        bbn.fn.link(this.root + 'cms/editor/' + row.id_note);
      },
      publishNote(row){
        let src =  bbn.fn.extend(row,{
          action: 'publish'
        });
        this.getPopup().open({
          width: 800,
          height: '80%',
          title: bbn._('Publish Note'),
          source: src,
          component: this.$options.components.form,
        });
      },
      unpublishNote(row){
        appui.confirm(bbn._('Are you sure to remove the publication from this note?'), () => {
          bbn.fn.post(this.root + 'cms/actions/unpublish',{id: row.id_note }, d =>{
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
      deleteNote(row){
        appui.confirm(bbn._('Are you sure to delete this note?'), () => {
          bbn.fn.post(this.root + "cms/actions/delete",{id: row.id_note }, (d) =>{
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
        if ( row.url !== null ){
          return '<a href="' + this.root + 'cms/preview/' + row.url +'" target="_blank">' + row.url + '</a>';
        }
        return '-';
      },
    },
    created(){
      appui.register('publications', this);
    },
    beforeDestroy(){
      appui.unregister('publications');
    },
    components: {
      menu: {
        template: `
<bbn-context :source="rowMenu">
	<span class="bbn-iblock bbn-lg bbn-hspadded">
  	<i class="nf nf-mdi-dots_vertical"/>
  </span>
</bbn-context>`,
        props: ['source'],
        data(){
          return {
            cp: false,
            table: false
          }
        },
        computed: {
          rowMenu(){
            if (!this.table) {
              return [];
            }

            return [{
              action: () => {
                this.cp.editNote(this.source);
              },
              icon: 'nf nf-fa-edit',
              text: bbn._("Edit"),
              key: 'a'
            }, {
              action: () => {
                this.cp.publishNote(this.source);
              },
              icon: 'nf nf-fa-chain',
              text: bbn._("Publish"),
              disabled: !this.source.is_published,
              key: 'b'
            }, {
              action: () => {
              	this.cp.unpublishNote(this.source);
              },
              icon: 'nf nf-fa-chain_broken',
              text: bbn._("Unpublish"),
              disabled: this.source.is_published,
              key: 'c'
            },{
              action: () => {
                this.cp.addMedia(this.source);
              },
              text: bbn._("Add media"),
              icon: 'nf nf-mdi-attachment',
              key: 'd'
            }, {
              action: () => {
                this.cp.deleteNote(this.source);
              },
              text: bbn._("Delete"),
              icon: 'nf nf-fa-trash_o',
              key: 'e'
            }];
          }
        },
        beforeMount(){
          this.table = this.closest('bbn-table');
          this.cp = this.closest('bbn-container').getComponent();
        }
      },
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
              this.post(this.root + '/cms/actions/add_media', {
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
            cp: appui.getRegistered('publications'),
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