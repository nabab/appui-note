/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 23/03/2018
 * Time: 15:39
 */
(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: {
      source: {
        type: Object
      },
      emptyCategories: {
        type: Array,
        default(){
          return []
        }
      }
    },
    data(){
      return {
        typeWatch: false
      }
    },
		computed: {
      action(){
        return this.root + 'actions/masks/' + (this.source.id_note ? 'update' : 'insert');
      }
    },
    methods: {
      getVersion(d){
        this.$set(this.source, 'id_note', d.id);
        this.$set(this.source, 'id_type', d.id_type);
        this.$set(this.source, 'title', d.title);
        this.$set(this.source, 'content', d.content);
        this.$set(this.source, 'creation', d.creation);
        this.$set(this.source, 'creator', d.id_user);
        this.$nextTick(() => {
          let editor = this.getRef('editor');
          if ( editor ){
            editor.onload();
          }
        });
      },
      success(d){
        if (d.success) {
          const table = this.masks.getRef('table');
          if (this.source.id_note) {
            let idx = bbn.fn.search(this.masks.source.categories, 'id_note', d.data.id_note);
            if (idx > -1) {
              bbn.fn.each(d.data, (v, i) => {
                if (i !== 'content') {
                  this.masks.source.categories[idx][i] = v;
                }
              });
            }
          }
          else {
            this.masks.source.categories.push(d.data);
          }

          table.updateData();
          appui.success(bbn._('Saved'));
        }
      }
    },
    created(){
      if (this.emptyCategories) {
        this.typeWatch = this.$watch('source.id_type', newVal => {
          this.source.name = bbn.fn.getField(this.emptyCategories, 'text', 'id', newVal);
        });
      }
    },
    beforeDestroy(){
      if (this.typeWatch) {
        this.typeWatch();
      }
    }
  }
})();
