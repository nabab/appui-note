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
      },
      availableFields(){
        if (this.source.id_type && this.masks) {
          return this.masks.getCategoryFields(this.source.id_type);
        }

        return [];
      }
    },
    methods: {
      getVersion(d){
        this.source.id_note = d.id;
        this.source.id_type = d.id_type;
        this.source.title = d.title;
        this.source.content = d.content;
        this.source.creation = d.creation;
        this.source.creator = d.id_user;
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
            let idx = bbn.fn.search(this.masks.source.list, 'id_note', d.data.id_note);
            if (idx > -1) {
              bbn.fn.each(d.data, (v, i) => {
                if (i !== 'content') {
                  this.masks.source.list[idx][i] = v;
                }
              });
            }
          }
          else {
            this.masks.source.list.push(d.data);
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
