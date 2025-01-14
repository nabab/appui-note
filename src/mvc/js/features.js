// Javascript Document

(() => {
  let that = null;
  return {
    data() {
      return {
        selected: "",
        selectedFeature: "",
        selectedText: "",
        selectedCode: "",
        selectedOrder: "",
        featureItems: [],
        showForm: false,
        orderModes: [{
          text: bbn._("Random"),
          value: "random"
        }, {
          text: bbn._("Latest published"),
          value: "latest"
        }, {
          text: bbn._("Earliest published"),
          value: "earliest"
        }, {
          text: bbn._("Manual order"),
          value: "manual"
        }],
      };
    },
    computed: {
      selectedOption() {
        if (!this.selected) {
          return null;
        }
        return bbn.fn.getRow(this.source.data, {id: this.selected});
      },
      orderedItems() {
        let new_arr = [];
        switch (this.selectedOrder) {
          case "random":
            new_arr = bbn.fn.shuffle(this.featureItems);
            break;
          case "latest":
            new_arr = bbn.fn.order(this.featureItems, 'start', 'desc');
            break;
          case "earliest":
            new_arr = bbn.fn.order(this.featureItems, 'start', 'asc');
            break;
          case "manual":
            new_arr = bbn.fn.order(this.featureItems, 'num', 'asc');
            break;
        }
        return new_arr;
      }
    },
    methods: {
      selectFeature(item) {
        if (!item) {
          this.selectedFeature = '';
          this.selected = '';
          this.featureItems = [];
        }
        else if (item.id) {
          bbn.fn.post(appui.plugins['appui-note'] + '/data/features', {
            id_option: item.id
          }, d => {
            if (d.success) {
              this.selectedFeature = item;
              this.selected = item.id;
              this.featureItems = d.data;
              this.$forceUpdate();
            }
          });
        }
      },
      addFeature(data) {
        if (this.selected && data.id_note) {
          bbn.fn.post(appui.plugins['appui-note'] + '/actions/feature/add_feature', {
            id_option: this.selected,
            id_note: data.id_note,
            num: this.featureItems.length + 1
          }, d => {
            if (d.success) {
              this.selectFeature(this.selectedFeature);
              appui.success(bbn._("Add successful"));
            }
          });
        }
      },
      removeNote(id) {
        bbn.fn.post(appui.plugins['appui-note'] + '/actions/feature/delete', {
          id_option: id,
        }, d => {
          if (d.success) {
            this.selectFeature(this.selectedFeature);
            appui.success(bbn._("Remove successful"));
          }
        });
      },
      updateOption() {
        let obj = {
          id: this.selected,
          text: this.selectedText,
          code: this.selectedCode,
          orderMode: this.selectedOrder,
        };
        bbn.fn.post(appui.plugins['appui-note'] + '/actions/feature/update', obj, d => {
          if (d.success) {
            bbn.fn.extend(this.selectedOption, obj);
            appui.success(bbn._("Update successful"));
          }
          this.selectFeature(obj);
        });
      },
      setOrderFeature(id, num) {
        bbn.fn.log(id, num);
        bbn.fn.post(appui.plugins['appui-note'] + '/actions/feature/order', {
          id: id,
          num: num
        }, d => {
          if (d.success) {
            this.selectFeature(this.selectedFeature);
            appui.success(bbn._("Update successful"));
          }
        });
      },
      openCategoryForm() {
        this.getPopup({
          label: bbn._("New category"),
          component: this.$options.components.form
        });
      },
      openGallery(item) {
        this.getPopup({
          component: this.$options.components.gallery,
          componentOptions: {
            item: item
          },
          label: bbn._('Select an image'),
          width: '90%',
          height: '90%'
        });
      },

    },
    beforeMount() {
      that = this;
    },
    watch: {
      selected(v) {
        if (!v) {
          this.selectedText = "";
          this.selectedCode = "";
          this.selectedOrder = "";
          this.featureItems = [];
        }
        else {
          this.selectedText = this.selectedOption.text;
          this.selectedCode = this.selectedOption.code;
          this.selectedOrder = this.selectedOption.orderMode || "random";
        }
      },
      selectedOrder(v) {
        this.selectFeature(this.selectedFeature);
      }
    },
    components: {
      gallery: {
        template: `
<div>
  <appui-note-media-browser :source="root + 'media/data/browser'"
                             @selection="onSelection"
                             @clickitem="onSelection"
                             :zoomable="false"
                             :selection="false"
                             :limit="50"
                             path-name="path"
                             :upload="root + 'media/actions/save'"
                             :remove="root + 'media/actions/delete'"
                             ref="mediabrowser"
                             @delete="onDelete"/>
</div>
        `,
        props: {
          item: {}
        },
        data(){
          return {
            root: appui.plugins['appui-note'] + '/'
          };
        },
        methods: {
          onSelection(img) {
            bbn.fn.post(appui.plugins['appui-note'] + '/actions/feature/set_media', {
              id: this.item.id,
              id_media: img.data.id
            }, d => {
              if (d.success) {
                let floater = this.closest("bbn-floater");
                if (floater && floater.opener) {
                  bbn.fn.log(img, this.item);
                  this.item.id_media = img.data.id;
                  this.$set(this.item, "media", img.data);
                }
                floater.close();
              }
            });
          },
          onDelete(obj){
            let id = bbn.fn.isArray(obj.media) ? bbn.fn.map(obj.media, m => m.id) : (obj.media.id || false);
            this.post(this.root + 'media/actions/delete', {id: id}, d => {
              if (d.success) {
                this.getRef('mediabrowser').refresh();
                appui.success();
              }
              else {
                appui.error();
              }
            });
          }
        }
      },
      form: {
        data() {
          return {
            newCategory: {
              text: "",
              code: ""
            },
            root: appui.plugins['appui-note'] + '/'
          };
        },
        methods: {
          addCategory(data) {
            bbn.fn.log(data, that);
            if (that && data.success) {
              this.newCategory.id = data.data.id;
              that.source.data.push(bbn.fn.clone(this.newCategory));
              this.newCategory.id = null;
              this.newCategory.text = "";
              this.newCategory.code = "";
              appui.success(bbn._("Update successful"));
              this.closest("bbn-floater").close();
            }
          },
        },
        template: `<bbn-form :source="newCategory"
                    					@success="addCategory"
                              :action="root + '/actions/feature/add_category'">
                    	<div class="bbn-grid-fields bbn-padding"
                           style="min-width: 20em">
                      	<div class="bbn-label">text</div>
                        <bbn-input title="text"
                        					 bbn-model="newCategory.text"
                                   :required="true"/>
                      	<div class="bbn-label">code</div>
                        <bbn-input title="code"
                                   bbn-model="newCategory.code"
                                   :required="true"/>
                      </div>
                    </bbn-form>`
      },
    }
  };
})();
