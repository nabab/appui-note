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
        notesRoot: appui.plugins['appui-note'],
        formData:{}
      }
    },
    methods: {
      validForm(){
        if ( this.formData.title.length ){
          return true;
        }
        else{
          appui.error(bbn._('Enter a title for the note'));
          return false;
        }
      },
      shorten: bbn.fn.shorten,
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
        this.showForm = false;
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
      openNews(){
        bbn.fn.link(appui.plugins['appui-note'] + '/news');
      },
      toggleForm(){
        let obj = {
          title: '',
          content: '',
          private: 0,
          locked: 0,
          type: this.source.id_type,
          start: dayjs().format('YYYY-MM-DD HH:mm:ss'),
          end: dayjs().add(10, 'minutes').format('YYYY-MM-DD HH:mm:ss')
        };
        this.$set(this, 'formData', obj);
        this.showForm = !this.showForm;
      },
      userName(usr){
        return usr && appui.getUserName ? appui.getUserName(usr) : '';
      }
    }
  };
})();
