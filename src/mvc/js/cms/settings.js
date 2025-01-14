// Javascript Document

(() => {
  return {
    data() {
      return {
        root: appui.plugins['appui-note'] + '/',
      	id_type: null,
        blocktype: null,
        currentSource: {},
        currentType: {}
    	};
    },
    computed: {
      blocks() {
        return bbn.fn.getRow(this.source.options, {code: 'blocks'});
      },
      currentEditor() {
        if (this.currentType.id_alias) {
          return bbn.fn.getRow(this.source.editors, {id: this.currentType.id_alias});
        }
        return null;
      },
      currentBlockConfig() {
        if (this.blocktype) {
          return bbn.fn.getField(this.blocks || [], 'cfg', {code: this.blocktype});
        }

        return false;
      }
    },
    methods: {
      selectDefault() {
        this.$nextTick(() => {
          this.getRef('list').select(0);
        })
      },
      browseAlias() {
        this.getPopup({
          width: 500,
          height: 600,
          label: bbn._('Options'),
          component: 'appui-option-browse',
          source: {
            data: this.currentType
          }
        });
      },
      blockCfg(block) {
        return bbn.fn.getRow(this.blocks, {code: block});
      }
    },
    watch: {
      id_type(v) {
        let r = {};
        if (v) {
          let o = bbn.fn.getRow(this.source.types, {id: this.id_type});
          if (o) {
            r = bbn.fn.extend({option: 0, front_img: '', option_title: '', id_root_alias: '', root_alias: ''}, o);
          }
        }

        this.currentType = r;
      },
      blocktype(v) {
        if (v) {
          this.currentSource = {
            type: v
          }
        }
      }
    }
  };
})();
