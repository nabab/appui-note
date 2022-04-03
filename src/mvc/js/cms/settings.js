// Javascript Document

(() => {
  return {
    data() {
      return {
      	id_type: null,
        blocktype: null,
        currentSource: {}
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
      currentType() {
        if (this.id_type) {
          return bbn.fn.getRow(this.source.types, {id: this.id_type});
        }

        return {};
      },
      currentBlockConfig() {
        if (this.blocktype) {
          return bbn.fn.getField(this.blocks, 'cfg', {code: this.blocktype});
        }
        
        return false;
      }
    },
    methods: {
      blockCfg(block) {
        return bbn.fn.getRow(this.blocks, {code: block});
      }
    },
    watch: {
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
