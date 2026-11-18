/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 23/02/2018
 * Time: 15:34
 */
(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: {
      source: {
        type: String
      }
    },
    data(){
      return {
        showForm: false,
        notesRoot: appui.plugins['appui-note'],
        formData:{},
        currentLimit: 0,
        currentPostData: {},
        isPagerVisible: false,
        listWatcher: null,
        hasListData: false
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
        let id_type = appui.options.notes_types ? bbn.fn.getField(appui.options.notes_types, 'value', {code: 'news'}) : this.source?.id_type;
        let evType = bbn.fn.getField(appui.options.evenements, 'value', {code: 'NEWS'});
        if (!id_type) {
          appui.error(bbn._("There doesn't seem to be a 'news' type of note in the system"));
          return;
        }

        let obj = {
          title: '',
          content: '',
          private: 0,
          locked: 0,
          id_type,
          type: evType,
          start: bbn.dt().format('YYYY-MM-DD HH:mm:ss'),
          end: bbn.dt().add(14, 'days').format('YYYY-MM-DD HH:mm:ss')
        };
        this.$set(this, 'formData', obj);
        this.showForm = !this.showForm;
      },
      openNote(note, a, b, ev){
        ev.preventDefault();
        this.closest('bbn-container').getPopup({
          label: note.title,
          width: '70%',
          height: '70%',
          component: 'appui-note-popup-note',
          source: note
        });
      },
      updateData(data, start, limit){
        if (!data) {
          data = {};
        }
        this.currentPostData = data;
        this.currentLimit = limit;
        this.getRef('list')?.updateData();
      },
      onListMounted(){
        this.listWatcher = this.getRef('list').$watch('currentTotal', newVal => {
          this.isPagerVisible = newVal > this.currentLimit;
          this.hasListData = !!newVal;
        });
      }
    },
    created(){
      this.$on('updateData', this.updateData);
    },
    beforeDestroy(){
      this.$off('updateData', this.updateData);
      if (this.listWatcher) {
        this.listWatcher();
      }
    },
    watch: {
      currentLimit(newVal){
        this.isPagerVisible = this.getRef('list')?.currentTotal > newVal;
      }
    },
    components: {
      item: {
        template: `
          <div style="column-gap: var(--xsspace); padding: var(--xsspace) 0"
               class="bbn-vmiddle">
            <bbn-initial width="20px" height="20px"
                         :user-id="source.id_user"
                         :user-name="userName(source.id_user)"/>
            <span bbn-text="shorten(source.title, 50)"
                  :title="source.title"
                  class="bbn-ellipsis"/>
          </div>
        `,
        props: {
          source: {
            type: Object,
            required: true
          }
        },
        methods: {
          shorten: bbn.fn.shorten,
          userName(usr){
            return usr && appui.getUserName ? appui.getUserName(usr) : '';
          }
        }
      }
    }
  };
})();
