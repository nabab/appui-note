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
      onSave(data) {
        if (data.id && this.hasNew) {
          let row = bbn.fn.getRow(this.source, {id: undefined});
          this.extend(row, data);
        }
        bbn.fn.log("Onsave", arguments);
      },
      getNewPostIt() {
        return {
          text: bbn._("Write here your content"),
          title: bbn._("Don't forget!"),
          date: bbn.fn.dateSQL(),
          bcolor: '#fbf7ae',
          fcolor: '#000000',
          pinned: true
        };
      },
      add() {
        this.source.push(this.getNewPostIt());
      }
    }
  }
})();
