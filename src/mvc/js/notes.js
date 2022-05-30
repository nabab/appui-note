/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 18/07/17
 * Time: 17.26
 */


(function(){
  return {
    data(){
      return bbn.fn.extend(this.source, {
        editedNote: false,
        choosing:false,
        newPostIt: null
      });
    },
    computed: {
      num() {
        return this.source.notes.length;
      }
    },
    methods: {
      add() {
        this.newPostIt = this.getNewPostIt();
      },
      isEditing(val){
        bbn.fn.log(val);
        return val === this.editedNote;
      },
      getNewPostIt() {
        return {
          text: '',
          title: '',
          date: bbn.fn.dateSQL(),
          bcolor: '#fbf7ae',
          fcolor: '#000000'
        };
      },
      onSave(postit) {
        if (postit && postit.id) {
          bbn.fn.log(postit, "YEAH");
          let row = bbn.fn.getRow(this.source.notes, {id: postit.id});
          if (row) {
            bbn.fn.extend(row, postit);
          }
          else {
            this.source.notes.unshift(postit);
          }
        }
      }
    },
    created() {
      if (!this.source.notes.length) {
        this.newPostIt = this.getNewPostIt();
      }
    },
    watch: {
      num() {
        this.newPostIt = null;
      }
    }
  }
})();