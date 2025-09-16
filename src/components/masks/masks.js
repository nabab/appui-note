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
              title: '',
              content: '',
              name: ''
            },
            emptyCategories: this.source.emptyCategories
          }
        });
      },
      toolbar() {
        const btns = [];
        if (appui.user.isDev) {
          btns.push({
            label: bbn._('Insert new category'),
            action: () => {
              this.getPopup({
                label: bbn._("New category of letters"),
                width: 500,
                component: 'appui-note-masks-type-form',
                componentEvents: {
                  success: () => {
                    this.$parent.getContainer().reload();
                  }
                }
              });
            },
            icon: 'nf nf-fa-plus'
          });
        }

        if (this.source.emptyCategories?.length) {
          btns.push({
            label: bbn._('Insert new letter'),
            action: () => {
              this.insert();
            },
            icon: 'nf nf-fa-plus'
          });
        }

        return btns;
      },
      renderButtons(row){
        const btns = [{
          label: bbn._("Edit"),
          icon: "nf nf-fa-edit",
          notext: true,
          action: () => this.edit(row),
        }, {
          label: bbn._("Delete"),
          icon: "nf nf-fa-trash",
          notext: true,
          action: () => this.removeItem(row),
          disabled: !!row.default
        }];
        if (this.hasCategoryPreview(row.id_type)) {
          btns.push({
            label: bbn._("Preview"),
            icon: "nf nf-cod-preview",
            notext: true,
            action: () => this.preview(row),
          });
        }
        return btns;
      },
      preview(row){
        if (row?.id_type && this.hasCategoryPreview(row.id_type)) {
          this.getPopup({
            width: 800,
            label: bbn._("Preview letter type"),
            component: 'appui-note-masks-preview',
            componentOptions: {
              source: row,
              inputs: this.getCategoryPreviewInputs(row.id_type)
            }
          });
        }
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
								let idx = bbn.fn.search(this.source.list, 'id_note', row.id_note);
								if (idx > -1) {
									this.source.list.splice(idx, 1);
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
      },
      getCategoryPreviewMode(idCategory){
        return idCategory ? bbn.fn.getField(this.source.categories, 'preview', 'id', idCategory) : false;
      },
      hasCategoryPreview(idCategory){
        return !!this.getCategoryPreviewMode(idCategory);
      },
      getCategoryProperty(idCategory, property) {
        const previewMode = this.getCategoryPreviewMode(idCategory);
        let res = null;
        if (previewMode) {
          switch (previewMode) {
            case 'model':
              const model = this.getCategoryPreviewModelByIdCategory(idCategory);
              if (model && (model[property] !== undefined)) {
                res = model[property];
              }

              break;
            case 'custom':
              const p = bbn.fn.getField(this.source.categories, property, 'id', idCategory);
              if (p !== undefined) {
                res = p;
              }

              break;
          }
        }

        return res;
      },
      getCategoryFields(idCategory) {
        let res = [];
        const fields = this.getCategoryProperty(idCategory, 'fields');
        const getList = fields => {
          const list = [];
          if (bbn.fn.isArray(fields)) {
            bbn.fn.each(fields, f => {
              list.push({
                field: f,
                items: []
              });
            })
          }
          else {
            bbn.fn.iterate(fields, (f, k) => {
              if (bbn.fn.isNumber(k)) {
                list.push({
                  field: f,
                  items: []
                });
              }
              else {
                list.push({
                  field: k,
                  items: getList(f)
                });
              }
            });
          }

          return list;
        };
        if (fields) {
          res = getList(fields)
        }

        return res;
      },
      getCategoryPreviewInputs(idCategory) {
        return this.getCategoryProperty(idCategory, 'preview_inputs') || {};
      },
      getCategoryPreviewModelId(idCategory){
        if (idCategory) {
          return bbn.fn.getField(this.source.categories, 'preview_model', 'id', idCategory) || false;
        }

        return false;
      },
      getCategoryPreviewModelByIdModel(idModel){
        if (idModel) {
          return bbn.fn.getRow(this.source.models, 'id', idModel) || false;
        }

        return false;
      },
      getCategoryPreviewModelByIdCategory(idCategory){
        return this.getCategoryPreviewModelByIdModel(this.getCategoryPreviewModelId(idCategory));
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
    },
    beforeDestroy(){
      appui.unregister('appui-note-masks');
    }
	}
})();
