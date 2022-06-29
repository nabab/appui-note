// Javascript Document

(() => {
  return {
    data() {
      return {
        currentSelected: "",
        currentSelectedText: "",
        currentSelectedCode: "",
        featureItems: [],
      };
    },
    computed: {
      currentSelectedOption() {
        if (!this.currentSelected) {
          return null;
        }
        return bbn.fn.getRow(this.source.data, {id: this.currentSelected});
      }
    },
    methods: {
      selectFeature(item) {
        if (item.id) {
          bbn.fn.post(appui.plugins['appui-note'] + '/data/features', {
            id_option: item.id
          }, d => {
            if (d.success) {
              this.currentSelected = item.id;
              this.featureItems = d.data;
            }
          });
        }
      },
      selectNote(data) {
        if (this.currentSelected && data.id_note) {
          bbn.fn.post(appui.plugins['appui-note'] + '/update_feature', {
            id_option: this.currentSelected,
            id_note: data.id_note
          }, d => {
            if (d.success) {
              bbn.fn.log(d);
            }
          });
        }
      }
    },
    watch: {
      currentSelected(v) {
        if (!v) {
          this.currentSelectedText = "";
          this.currentSelectedCode = "";
          this.featureItems = [];
        }
        else {
          this.currentSelectedText = this.currentSelectedOption.text;
          this.currentSelectedCode = this.currentSelectedOption.code;
        }
      }
    }
  };
})();
