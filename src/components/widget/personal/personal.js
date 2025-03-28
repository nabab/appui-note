/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 23/02/2018
 * Time: 15:34
 */
(() => {
  return {
    data(){
      return {
        showForm: false,
        // formData: {
        //   title: '',
        //   content: '',
        //   postit: 0,
        //   type: this.source.id_type
        // }
        formData: {}
      }
    },
    methods: {
      shorten: bbn.fn.shorten,
      html2text: bbn.fn.html2text,
      afterSubmit(d){
        if ( d.success ){
          appui.success(bbn._('Saved'));
          this.closest('bbn-widget').reload();
          this.closeForm();
        }
        else {
          appui.error();
        }
      },
      closeForm(){
        this.$refs.form.reset();
        this.toggleForm();
      },
      openNote(note){
        this.closest('bbn-container').getPopup({
          label: note.title,
          width: '70%',
          height: '70%',
          component: 'appui-note-popup-note',
          source: note
        });
      },
      openPostit(){
        bbn.fn.link(appui.plugins['appui-note'] + '/post-it');
      },
      toggleForm(){
        let obj = {
          title: '',
          content: '',
          postit: 0,
          type: this.source.id_type
        };
        this.$set(this, 'formData', obj);
        this.showForm = !this.showForm;
      },
      userName(usr){
        return appui?.getUserName ? appui.getUserName(usr) : bbn._('Unknown');
      }
    }
  };
})();
