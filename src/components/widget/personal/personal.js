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
        formData: {},
        currentLimit: 0,
        currentPostData: {},
        isPagerVisible: false,
        listWatcher: null,
        hasListData: false,
        isLoading: false
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
      openPostit(){
        bbn.fn.link(appui.plugins['appui-note'] + '/post-it');
      },
      toggleForm(){
        let obj = {
          title: '',
          content: '',
          postit: 0,
          private: 1,
          type: this.source.id_type
        };
        this.$set(this, 'formData', obj);
        this.showForm = !this.showForm;
      },
      updateData(data, start, limit){
        if (!data) {
          data = {};
        }
        this.currentPostData = data;
        this.currentLimit = limit;
        this.$nextTick(() => {
          const list = this.getRef('list');
          if (list) {
            list.updateData();
          }
          else {
            this.$once('listMounted', () => {
              this.getRef('list').updateData();
            });
          }
        });
      },
      onListMounted(){
        this.$emit('listMounted');
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
            <span bbn-text="text"
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
        data(){
          return {
            text: bbn.fn.shorten(this.source.title, 50)
            || bbn.fn.html2text(bbn.fn.shorten(this.source.content, 50))
          }
        },
        methods: {
          userName(usr){
            return usr && appui.getUserName ? appui.getUserName(usr) : '';
          }
        }
      }
    }
  };
})();
