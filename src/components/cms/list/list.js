// Javascript Document
(() => {
  const root = appui.plugins['appui-note'] + '/';
  return {
    mixins: [bbn.cp.mixins.basic],
    statics() {
      return {
        root
      }
    },
    props: {
      source: {
        type: Object
      },
      id_type: {
        type: String
      },
      noteName: {
        type: String,
        default: bbn._("Post")
      },
      columns: {
        type: Array,
        default() {
          return [];
        }
      },
      url: {
        type: String,
        default() {
          return root + 'cms/cat'
        }
      },
      previewUrl: {
      	type: String,
        default() {
          return root + 'cms/preview/'
        }
      },
      mediaUrl: {
        type: String,
        default() {
          return root + 'cms/actions/add_media'
        }
      },
      publishUrl: {
        type: String,
        default() {
          return root + 'cms/actions/publish'
        }
      },
      unpublishUrl: {
        type: String,
        default() {
          return root + 'cms/actions/unpublish'
        }
      },
      insertUrl: {
        type: String,
        default() {
          return root + 'cms/actions/insert'
        }
      },
      deleteUrl: {
        type: String,
        default() {
          return root + 'cms/actions/delete'
        }
      },
      moveUrl: {
        type: String,
        default: root + 'cms/actions/move'
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
      moveComponent: {
        type: [String, Object],
        default: 'appui-note-cms-form-move'
      },
      toolbarComponent: {
        type: [String, Object],
        default: 'appui-note-cms-list-toolbar'
      },
      toolbarTypes: {
        type: Boolean,
        default: true
      },
      root: {
        type: [String],
        default() {
          return root
        }
      },
      actions: {
        type: [Array, Function]
      },
    },
    data(){
      let storage = window.localStorage.getItem('appui-cms-list');
      let currentCategory = this.id_type || 'all'
      if (storage) {
        storage = JSON.parse(storage).value;
        if (storage.filters?.conditions?.length){
          let cc = bbn.fn.getField(storage.filters.conditions, 'value', 'field', 'id_type');
          if (!!cc) {
            currentCategory = cc;
          }
        }
      }
      return {
        users: appui.users,
        currentCategory: currentCategory
      };
    },
    computed: {
      types(){
        return this.source.types_notes;
      },
      typesTextValue(){
        return bbn.fn.map(bbn.fn.clone(this.types), t => {
          return {
            text: t.text,
            value: t.id
          }
        });
      },
      currentType() {
        return bbn.fn.getRow(this.types, {id: this.currentCategory});
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
            title: bbn._("Post"),
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
            //cls: "bbn-middle",
            hidden: (this.currentCategory !== 'all') && !this.currentType.front_img,
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
            width: 200,
            source: this.typesTextValue,
            hidden: this.currentCategory !== 'all',
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
			}
    },
    methods: {
      renderFrontImg(a) {
        if (a.id_media) {
          return '<img src="' + appui.plugins['appui-note'] + '/media/image/' + a.id_media + '?w=100" style="width: 100%; object-fit: cover; aspect-ratio: 1">';
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
          text: bbn._("Edit")
        }, {
          action: () => {
            this.moveNote(row);
          },
          icon: 'nf nf-md-folder_move',
          text: bbn._("Move to another category")
        }, {
          action: () => {
            this.publishNote(row);
          },
          icon: 'nf nf-fa-chain',
          text: bbn._("Publish"),
          disabled: this.isPublished(row)
        }, {
          action: () => {
            this.unpublishNote(row);
          },
          icon: 'nf nf-fa-chain_broken',
          text: bbn._("Unpublish"),
          disabled: !this.isPublished(row)
        }, {
          action: () => {
            this.deleteNote(row);
          },
          text: bbn._("Delete"),
          icon: 'nf nf-fa-trash_o'
        }, {
          action: () => {
            window.open(row.url);
          },
          text: bbn._("Open in a new window"),
          icon: 'nf nf-mdi-open_in_new'
        }];
      },
      insertNote(){
        this.getPopup({
          width: 800,
          title: bbn._('New') + ' ' + this.noteName,
          component: this.insertComponent,
          componentOptions: {
            id_type: this.currentCategory !== 'all' ? this.currentCategory : '',
            source: {
              url: this.insertUrl,
            },
            types: this.types
          }
        });
      },
      editNote(row) {
        if (!!row.id || !!row.id_note) {
          let catCode = bbn.fn.getField(this.types, 'code', 'id', row.id_type);
          let url = this.editorUrl || (root + 'cms/cat/' + catCode + '/editor/');
          bbn.fn.link(url + (row.id || row.id_note));
        }
      },
      publishNote(row){
        this.getPopup().open({
          width: 400,
          title: bbn._('Post publication'),
          component: this.publishComponent,
          componentOptions: {
            url: this.publishUrl,
            list: this.getRef('table'),
            source: bbn.fn.isObject(row) ? row.id_note : row
          }
        });
      },
      unpublishNote(row){
        let mess = bbn.fn.isObject(row) ?
          bbn._('Are you sure you want to cease the publication of this post?') :
          bbn._('Are you sure you want to cease the publication of the selected posts?')
        appui.confirm(mess, () => {
          bbn.fn.post(this.unpublishUrl, {
            id: bbn.fn.isObject(row) ? row.id_note : row
          }, d =>{
            if (d.success) {
              appui.success(d.message || bbn._('Successfully removed from publications'));
            }
            else {
              appui.error(bbn._('Error in this action'));
            }
            if (bbn.fn.isArray(row)) {
              this.getRef('table').currentSelected.splice(0);
            }
            this.updateData();
          });
        });
      },
      deleteNote(row){
        let msg = bbn.fn.isArray(row) ?
        bbn._('Are you sure you want to delete the selected posts?') :
        bbn._('Are you sure to delete this post?');
        if (row.num_variants) {
          if (row.num_variants === 1) {
            msg += '<br>' + bbn._('There is also one variant');
          }
          else {
            msg += '<br>' + bbn._('There are also %d variants', row.num_variants);
          }
        }

        if (row.num_translations) {
          if (row.num_translations === 1) {
            msg += '<b r>' + (!!row.num_variants ?
              bbn._('and also one translation') :
              bbn._('There is also one translation'));
          }
          else {
            msg += '<br>' + (!!row.num_variants ?
              bbn._('and also %d translations', row.num_translations) :
              bbn._('There are also %d translations', row.num_translations));
          }
        }

        if (!!row.num_variants || !!row.num_translations) {
          msg += '<br>' + bbn._("which will be deleted too");
        }
        appui.confirm(msg, () => {
          bbn.fn.post(this.deleteUrl, {
            id: bbn.fn.isObject(row) ? (row.id || row.id_note) : row
          }, d =>{
            if (d.success) {
              appui.success(d.message || bbn._('Successfully deleted'));
            }
            else{
              appui.error(bbn._('Error in deleting'));
            }
            if (bbn.fn.isArray(row)) {
              this.getRef('table').currentSelected.splice(0);
            }
            this.updateData();
          });
        });
      },
      moveNote(row){
        this.getPopup().open({
          width: 400,
          title: bbn._('Move post to another category'),
          component: this.moveComponent,
          componentOptions: {
            url: this.moveUrl,
            source: bbn.fn.isObject(row) ? row.id_note : row
          }
        });
      },
      filterTable(type) {
        let table = this.getRef('table');
        let idx = bbn.fn.search(table.currentFilters.conditions, 'field', 'id_type');
        if (type === 'all') {
          if (idx > -1) {
            table.currentFilters.conditions.splice(idx, 1);
          }
        }
        else {
          if (idx > -1) {
            table.$set(table.currentFilters.conditions[idx], 'value', type);
          }
          else {
            table.currentFilters.conditions.push({
              field: 'id_type',
              value: type
            });
          }
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
        if (this.getRef('table')) {
          this.getRef('table').updateData();
        }
      },
      setPublishedFilter(){
        let table = this.getRef('table');
        if (table) {
          let filter = {
            id: 'statusFilter',
            val: 'published',
            conditions: [{
              field: 'start',
              operator: '<=',
              exp: 'NOW()'
            }, {
              logic: 'OR',
              conditions: [{
                field: 'end',
                operator: 'isnull'
              }, {
                field: 'end',
                operator: '>',
                exp: 'NOW()'
              }]
            }]
          }
          let idx = bbn.fn.search(table.currentFilters.conditions, 'id', 'statusFilter');
          if (idx > -1) {
            table.currentFilters.conditions.splice(idx, 1, filter);
          }
          else {
            table.currentFilters.conditions.push(filter);
          }
        }
      },
      setUnpublishedFilter(){
        let table = this.getRef('table');
        if (table) {
          let filter = {
            id: 'statusFilter',
            val: 'unpublished',
            conditions: [{
              logic: 'OR',
              conditions: [{
                field: 'start',
                operator: 'isnull'
              }, {
                field: 'start',
                operator: '>',
                exp: 'NOW()'
              }, {
                field: 'end',
                operator: '<=',
                exp: 'NOW()'
              }]
            }]
          }
          let idx = bbn.fn.search(table.currentFilters.conditions, 'id', 'statusFilter');
          if (idx > -1) {
            table.currentFilters.conditions.splice(idx, 1, filter);
          }
          else {
            table.currentFilters.conditions.push(filter);
          }
        }
      },
      unsetStatusFilter(){
        let table = this.getRef('table');
        if (table) {
          let idx = bbn.fn.search(table.currentFilters.conditions, 'id', 'statusFilter');
          if (idx > -1) {
            table.currentFilters.conditions.splice(idx, 1);
          }
        }
      }
    },
    created(){
      appui.register('appui-note-cms-list', this);
    },
    beforeDestroy(){
      appui.unregister('appui-note-cms-list');
    },
    watch: {
      currentCategory(newVal){
        this.$nextTick(() => {
          this.filterTable(newVal);
        });
      },
      currentColumns(newVal){
        this.$nextTick(() => {
          let table = this.getRef('table');
          bbn.fn.each(newVal, (c, i) => {
            if (!!c.hidden && !table.currentHidden.includes(i)) {
              table.currentHidden.push(i);
            }
            else if (!c.hidden && !!table.currentHidden.includes(i)) {
              table.currentHidden.splice(table.currentHidden.indexOf(i), 1);
            }
          });
        })
      }
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
  <bbn-floater bbn-if="showFilter"
               :auto-hide="true"
               @beforeclose="showFilter = false"
               @close="showFilter = false"
               :element="$refs.icon">
    <div class="bbn-padding">
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
<div class="appui-note-cms-list-titlecell bbn-nowrap">
  <div class="bbn-vmiddle">
    <span :title="publicationState"
          class="bbn-right-space bbn-xl">
      <i :class="{
           'bbn-green nf nf-fa-check_circle_o': isPublished,
           'bbn-red bbn-lg nf nf-fa-times_circle_o': !isPublished
         }"/>
    </span>
    <span class="bbn-vmiddle bbn-right-space bbn-border bbn-radius bbn-right-xspadding bbn-background bbn-text"
          :style="{borderColor: currentBorderColor + '!important'}">
      <bbn-initial :user-name="name"
                    :width="18"
                    class="bbn-xs bbn-right-xsspace"
                    @hook:mounted="onInitialMounted"
                    ref="initial"/>
      <span bbn-text="name"/>
    </span>
    <span class="bbn-vmiddle bbn-right-space bbn-border bbn-radius bbn-right-xspadding bbn-background bbn-text colorblock orange"
          :title="_('Since') + ' ' + fdate(source.creation)">
      <i class="nf nf-md-calendar_edit bbn-lg bbn-right-xsspace bbn-hxxspadding"/>
      <span bbn-text="fdate(source.creation)"/>
    </span>
    <span bbn-if="source.start"
          class="bbn-vmiddle bbn-border bbn-radius bbn-right-xspadding bbn-right-space bbn-background bbn-text colorblock green"
          :title="_('Published') + ' ' + fdate(source.start)">
      <i class="nf nf-md-calendar_check bbn-lg bbn-right-xsspace bbn-hxxspadding"/>
      <span bbn-text="fdate(source.start)"/>
    </span>
    <span class="bbn-vmiddle bbn-border bbn-radius bbn-right-xspadding bbn-right-space bbn-background bbn-text colorblock"
          :title="_('Version') + ' ' + source.version">
      <i class="nf nf-cod-versions bbn-lg bbn-right-xsspace bbn-hxxspadding"/>
      <span bbn-text="source.version"/>
    </span>
    <span :title="_('Number of medias directly linked to this article')"
          class="bbn-vmiddle bbn-border bbn-radius bbn-right-xspadding bbn-right-space bbn-background bbn-text colorblock">
      <i class="nf nf-md-image_multiple bbn-lg bbn-right-xsspace bbn-hxxspadding"/>
      <span bbn-text="source.num_medias"/>
    </span>
    <span :title="_('Number of variants of this article')"
          class="bbn-vmiddle bbn-border bbn-radius bbn-right-xspadding bbn-right-space bbn-background bbn-text colorblock">
      <i class="nf nf-md-content_duplicate bbn-lg bbn-right-xsspace bbn-hxxspadding"/>
      <span bbn-text="source.num_variants"/>
    </span>
    <span :title="_('Number of translations for this article')"
          class="bbn-vmiddle bbn-border bbn-radius bbn-right-xspadding bbn-right-space bbn-background bbn-text colorblock">
      <i class="nf nf-md-translate bbn-lg bbn-right-xsspace bbn-hxxspadding"/>
      <span bbn-text="source.num_translations"/>
    </span>
  </div>
  <div class="bbn-xl bbn-top-sspace bbn-p"
       bbn-text="source.title"
       :title="source.title"
       @click="editPost"/>
</div>`,
        props: ['source'],
        data() {
          return {
            name: bbn.fn.getField(appui.users || [], 'text', {value: this.source.id_user}) || bbn._("Unknown"),
            currentBorderColor: 'var(--default-border)'
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
          fdate: bbn.fn.fdate,
          onInitialMounted(){
            this.currentBorderColor = this.getRef('initial').currentColor;
          },
          editPost(){
            appui.getRegistered('appui-note-cms-list').editNote(this.source);
          }
        }
      },
      publication: {
        template: `
<span class="bbn-nowrap">
  <i class="bbn-green bbn-xl nf nf-fa-check_circle_o"
  	 bbn-if="isPublished"/>
  <i class="bbn-red bbn-xl nf nf-fa-times_circle_o"
  	 bbn-else/>
</span>`,
        props: ['source'],
        data(){
          return {
            name: bbn.fn.getField(appui.users, 'text', {value: this.source.id_user})
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
            name: bbn.fn.getField(appui.users, 'text', {value: this.source.id_user})
          }
        }
      }
    }
  }
})();
