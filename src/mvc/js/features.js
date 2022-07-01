// Javascript Document

(() => {
  return {
    data() {
      return {
        selected: "",
        selectedFeature: "",
        selectedText: "",
        selectedCode: "",
        selectedOrder: "",
        featureItems: [],
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
      addNote(data) {
        if (this.selected && data.id_note) {
          bbn.fn.post(appui.plugins['appui-note'] + '/actions/feature/add', {
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
      }
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
    }
  };
})();
