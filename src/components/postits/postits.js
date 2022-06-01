// Javascript Document

(() => {
  return {
    mixins: ['bbn.vue.basicComponent'],
    props: {
      source: {
      	type: Array,
        required: true
	    }
    },
    computed: {
      hasNew() {
        return !!bbn.fn.getRow(this.source, {id: undefined});
      }
    },
    methods: {
      onClick(e) {
        if (!bbn.fn.isInside(e.target, '.appui-note-postit')) {
          this.$emit('close');
        }
      },
      onRemove(data) {
        let idx = bbn.fn.search(this.source, {id: data.id || undefined});
        bbn.fn.log("On remove", idx)
        if (this.source[idx]) {
          this.source.splice(idx, 1);
        }
      },
      onSave(data) {
        if (data.id) {
          let row = bbn.fn.getRow(this.source, {id: data.id});
          if (!row) {
            row = bbn.fn.getRow(this.source, {id: undefined});
          }
          if (row) {
            this.extend(row, data);
          }
        }
      },
      getNewPostIt() {
        return {
          text: bbn._("Write here your content"),
          title: bbn._("Don't forget!"),
          date: bbn.fn.dateSQL(),
          bcolor: '#fbf7ae',
          fcolor: '#000000',
          pinned: true,
          id: undefined
        };
      },
      add() {
        this.source.push(this.getNewPostIt());
      }
    }
  }
})();
