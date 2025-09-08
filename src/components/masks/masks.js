(() => {
  let mixins = [bbn.cp.mixins.basic, {
    data() {
      const nm = appui.getRegistered('appui-note-masks');
      return {
        masks: nm,
        root: nm.root
      };
    }
  }];
  bbn.cp.addUrlAsPrefix(
    'appui-note-masks-',
    'components/',
    mixins
  );

  return {
    mixins: [
      bbn.cp.mixins.basic,
      bbn.cp.mixins.localStorage
    ],
    props: {
      storage: {
        type: Boolean,
        default: true
      },
      storageFullName: {
        type: String,
        default: 'appui-note-masks-warning'
      }
    },
    data(){
      return {
        root: appui.plugins['appui-note'] + '/'
      }
    },
    methods: {
      insert(){
        this.getPopup({
          label: bbn._("New letter type"),
          width: 800,
          height: '90%',
          component: 'appui-note-masks-form',
          componentOptions: {
            source: {
              id_type: '',
              label: '',
              content: '',
              name: ''
            },
            emptyCategories: this.source.emptyCategories
          }
        });
      },
      toolbar() {
        return [{
          text: bbn._('Insert new '),
          action: () => {
            this.insert();
          },
          icon: 'nf nf-fa-plus'
        }]
      },
      renderButtons(row){
        return [{
          text: bbn._("Edit"),
          icon: "nf nf-fa-edit",
          notext: true,
          action: this.edit,
        }, {
          text: bbn._("Delete"),
          icon: "nf nf-fa-trash",
          notext: true,
          action: this.removeItem,
          disabled: !!row.default
        }];
      },
      renderUser(row){
        return appui.getUserName(row.id_user)
      },
      edit(row){
        this.post(this.root + 'actions/masks/get', {
          id_note: row.id_note,
          version: row.version
        }, d => {
          if (d.success && d.data) {
            d.data.hasVersions = d.data.version > 1;
            this.getPopup({
              width: 800,
              height: '90%',
              component: 'appui-note-masks-form',
              source: d.data,
              label: bbn._("Edit letter type")
            })
          }
        })
      },
      removeItem(row){
        if ( row.id_note ){
          appui.confirm(bbn._("Are you sure you want to delete this letter?"), () => {
            this.post(this.root + 'actions/masks/delete', {id_note: row.id_note}, d => {
              if (d.success) {
								let idx = bbn.fn.search(this.source.categories, 'id_note', row.id_note);
								if (idx > -1) {
									this.source.categories.splice(idx, 1);
									this.getRef('table').updateData();
									appui.success(bbn._('Deleted'));
								}
              }
							else {
								appui.error(bbn._('Error'));
							}
            });
          });
        }
      },
      showWarning() {
        this.getPopup({
          minWidth: 550,
          maxWidth: '80%',
          scrollable: false,
          closable: false,
          label: bbn._("Warning on standard letters"),
          component: 'appui-note-masks-warning',
          source: {
            doNotShowAgainValue: this.getStorage() || false
          }
        });
      }
    },
    created(){
      appui.register('appui-note-masks', this);
    },
    mounted() {
      if (this.getStorage()) {
        this.$parent.getContainer().addMenu({
          text: bbn._("Show warning message"),
          icon: "nf nf-cod-warning",
          action: () => {
            this.showWarning()
          }
        });
        this.$parent.getContainer().addMenu({
          text: bbn._("Show warning message when opening"),
          icon: "nf nf-fa-warning",
          action: () => {
            this.setStorage(false)
          }
        })
      }
      else {
        this.$nextTick(() => {
          this.showWarning()
        });
      }
    }
	}
})();
