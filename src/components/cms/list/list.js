// Javascript Document// Javascript Document
(() => {
  let root = appui.plugins['appui-note'] + '/';

  return {
    mixins: [bbn.vue.basicComponent],
    props: {
      source: {
        type: Object
      },
      id_type: {
        type: String
      },
      noteName: {
        type:String,
        default: bbn._("Note")
      },
      columns: {
        type: Array,
        default() {
          return [];
        }
      },
      url: {
        type: String,
        default: root + 'cms/cat/'
      },
      previewUrl: {
      	type: String,
        default: root + 'cms/preview/'
      },
      mediaUrl: {
        type: String,
        default: root + 'cms/actions/add_media'
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
        type: String
      },
      publishComponent: {
        type: [String, Object],
        default: 'appui-note-cms-form-publish'
      },
      insertComponent: {
        type: [String, Object],
        default: 'appui-note-cms-form-insert'
      },
      root: {
        type: [String],
        default: root
      },
      actions: {
        type: [Array, Function]
      },
    },
    data(){
      return {
        users: appui.app.users
      };
    },
    computed: {
      types(){
        return this.source.types_notes;
      },
      currentColumns() {
        let defaultColumns = [
          {
            title: " ",
            buttons: this.rowMenu,
            filterable: false,
            showable: false,
            sortable: false,
            width: 30,
            maxWidth: 30,
            cls: "bbn-c"
          }, {
            field: "id",
            hidden: true,
            minWidth: 130,
            title: bbn._("ID")
          }, {
            filterable: false,
            minWidth: 350,
            width: 500,
            title: bbn._("Article"),
            component: this.$options.components.titleCell
          }, {
            field: "version",
            width: 40,
            hidden: true,
            title: "V",
            ftitle: bbn._("Version"),
            cls: "bbn-c"
          }, {
            field: "title",
            minWidth: 350,
            width: 500,
            title: bbn._("Title"),
            hidden: true,
          }, {
            field: "id_media",
            title: bbn._("Cover image"),
            render: this.renderFrontImg,
            editable: false,
            cls: "bbn-middle",
            hidden: !this.currentType.front_img,
            width: 100
          }, {
            field: "url",
            title: bbn._("URL"),
            minWidth: 200,
            render: this.renderUrl,
            hidden: true
          }, {
            field: "id_type",
            title: bbn._("Type"),
            width: 100,
            source: this.types,
            hidden: true,
            default: this.id_type
          }, {
            field: "id_option",
            hidden: !this.currentType.option,
            width: 250,
            source: this.currentType.options || [],
            title: this.currentType.option_title || bbn._("Category")
          }, {
            field: "excerpt",
            hidden: true,
            width: 250,
            title: bbn._("Excerpt")
          }, {
            field: "start",
            type: "date",
            width: 100,
            title: bbn._("Start of publication"),
            hidden: true
          }, {
            field: "end",
            type: "date",
            width: 100,
            title: bbn._("End of publication"),
            hidden: true
          }, {
            field: "creation",
            type: "date",
            width: 100,
            hidden: true,
            title: bbn._("Since")
          }, {
            field: "id_user",
            ftitle: bbn._("Creator"),
            title: '<<i class="nf nf-fa-user"></i>',
            cls: 'bbn-c',
            hidden: true,
            width: 50,
            component: this.$options.components.initial
          }, {
            field: "num_medias",
            width: 50,
            title: "<i class='nf nf-fa-file_photo_o bbn-lg'> </i>",
            ftitle: bbn._("Number of medias associated with this entry"),
            hidden: true,
            type: "number",
            cls: "bbn-c"
          }
				];
        let columns = this.columns.slice();
        bbn.fn.each(this.columns, (c, k) => {
          let ok = true;
          if (c.field) {
            let idx = bbn.fn.search(defaultColumns, {field: c.field});
            if (idx > -1) {
              defaultColumns.splice(idx, 1, c);
              ok = false;
            }
          }
          else if (c.buttons && defaultColumns[0].buttons) {
            defaultColumns.splice(0, 1, c);
            ok = false;
          }

          if (ok) {
            defaultColumns.push(c);
          }
        });

        return defaultColumns;
			},
      currentType() {
        return bbn.fn.getRow(this.types, {id: this.id_type});
      }
    },
    methods: {
      renderFrontImg(a) {
        if (a.id_media) {
          return '<img src="' + appui.plugins['appui-note'] + '/media/image/' + a.id_media + '?w=100">';
        }

        return '';
      },
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
            id_type: this.id_type || '',
            source: {
              url: this.insertUrl,
            },
            types: this.types
          }
        });
      },
      // methods each row of the table
      editNote(row) {
        let url = this.editorUrl || (this.root + 'cms/cat/' + this.currentType.code + '/editor/');
        bbn.fn.link(url + (row.id || row.id_note));
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
        let msg = bbn._('Are you sure to delete this note?');
        if (row.num_variants) {
          if (row.num_variants === 1) {
            msg += '<br>' + bbn._('There is also one variant');
          }
          else {
            msg += '<br>' + bbn._('There are also %d variants', row.num_variants);
          }

          if (row.num_translations) {
            if (row.num_translations === 1) {
              msg += '<br>' + bbn._('and also one translation');
            }
            else {
              msg += '<br>' + bbn._('and also %d translations', row.num_translations);
            }
          }

          msg += '<br>' + bbn._("which will be deleted too");
        }
        else if (row.num_translations) {
          if (row.num_translations === 1) {
            msg += '<br>' + bbn._('There is also one translation');
          }
          else {
            msg += '<br>' + bbn._('There are also %d translations', row.num_translations);
          }

          msg += '<br>' + bbn._("which will be deleted too");
        }
        appui.confirm(msg, () => {
          bbn.fn.post(this.deleteUrl, {id: row.id || row.id_note }, (d) =>{
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
          return '<a href="' + row.url + '" target="_blank">' + row.url + '</a>';
        }

        return '-';
      },
      updateData() {
        this.getRef('table').updateData();
      }
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
      pubTitle: {
        template: `
<span>
  <span class="bbn-nowrap">
    <i class="nf nf-mdi-filter_variant bbn-p"
       @click="showFilter = !showFilter"
       ref="icon"/> 
    <i class='nf nf-fa-calendar bbn-lg'
       title="source.title"/>
  </span>
  <bbn-floater v-if="showFilter"
               :auto-hide="true"
               @beforeClose="showFilter = false"
               @close="showFilter = false"
               :element="$refs.icon">
    <div class="bbn-padded">
    	Hello!
    </div>
  </bbn-floater>
</span>`,
        props: ['source'],
        data(){
          return {
            showFilter: false
          }
        }
      },
      titleCell: {
        template: `
<span class="bbn-nowrap">
  <a :href="source.url"
     target="_blank"
     :title="_('Open the article in a new window')">
	  <i class="nf nf-mdi-open_in_new"/>
  </a> 
  <span class="bbn-lg"
        v-text="source.title"
        :title="source.title"/><br>

  <div class="bbn-w-100 bbn-top-xsspace">
    <div class="bbn-w-50">
      <span :title="publicationState"
            class="bbn-right-sspace">
        <i class="bbn-green bbn-xl nf nf-fa-check_circle_o"
           v-if="isPublished"/>
        <i class="bbn-red bbn-xl nf nf-fa-times_circle_o"
           v-else/>
      </span>
      <span class="bbn-alt-text bbn-right-sspace"
            v-text="'v' + source.version"
            :title="_('Version') + ' ' + source.version"/> 
      <span :title="_('Number of medias directly linked to this article')"
            class="bbn-right-sspace">
      	<i class="nf nf-fa-file_photo_o bbn-xl"/> 
        <span v-text="source.num_medias"/>
      </span> 
      <span :title="_('Number of variants of this article')"
            class="bbn-right-sspace">
      	<i class="nf nf-fa-clone bbn-xl"/> 
        <span v-text="source.num_variants"/>
      </span> 
      <span :title="_('Number of translations for this article')"
            class="bbn-right-sspace">
      	<i class="nf nf-mdi-translate bbn-xl"/> 
        <span v-text="source.num_translations"/>
      </span> 
    </div>
    <div class="bbn-w-50 bbn-r bbn-line-vmiddle">
      <div>
        <span v-text="_('Since') + ' ' + fdate(source.creation)"/> <br>
        <span v-if="source.start" v-text="_('Published') + ' ' + fdate(source.start)"></span>
      </div>
      <bbn-initial :user-name="name"
                   :width="24"
                   class="bbn-xs"/>
    </div>
  </div>
</span>`,
        props: ['source'],
        data(){
          return {
            name: bbn.fn.getField(appui.app.users, 'text', {value: this.source.id_user})
          }
        },
        computed: {
          publicationState(){
            let st = '';
            if (this.isPublished) {
              st += bbn._("Currently published");
            }
            else {
              st += bbn._("Currently not published");
            }

            st += ".\n";
            if (this.source.start) {
              st += bbn._("Publication date") + ': ' + bbn.fn.fdate(this.source.start);
            }
            else {
              st += bbn._("Never published");
            }

            if (this.source.end) {
              st += "\n" + bbn._("End of publication") + ': ' + bbn.fn.fdate(this.source.end);
            }

            return st;
          },
          isPublished() {
            if (this.source.start) {
              let now = bbn.fn.dateSQL();
              if (!this.source.end || (this.source.end > now)) {
                return true;
              }
            }

            return false;
          },
        },
        methods: {
          fdate: bbn.fn.fdate
        }
      },
      publication: {
        template: `
<span class="bbn-nowrap">
  <i class="bbn-green bbn-xl nf nf-fa-check_circle_o"
  	 v-if="isPublished"/>
  <i class="bbn-red bbn-xl nf nf-fa-times_circle_o"
  	 v-else/>
</span>`,
        props: ['source'],
        data(){
          return {
            name: bbn.fn.getField(appui.app.users, 'text', {value: this.source.id_user})
          }
        },
        computed: {
          isPublished() {
            if (this.source.start) {
              let now = bbn.fn.dateSQL();
              if (!this.source.end || (this.source.end > now)) {
                return true;
              }
            }

            return false;
          },
        },
        methods: {
          fdate: bbn.fn.fdate
        }
      },
      initial: {
        template: `<bbn-initial :user-name="name"/>`,
        props: ['source'],
        data(){
          return {
            name: bbn.fn.getField(appui.app.users, 'text', {value: this.source.id_user})
          }
        }
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