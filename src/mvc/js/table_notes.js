/*avevo provato su questa tabella a fare un componente interno per le nuove note ma non lo vede*/
(function(){
  return {
    data(){
      return {
        action: '',
        root: appui.plugins['appui-note'] + '/',
        users: bbn.fn.order(appui.users, {text: 'asc'}),
        span: '<span title="' + bbn._('Click on the first column of this row to view full content') + '">...</span>'
      }
    },
    methods: {
      getType(row) {
        let res = '-';
        if (row.id_type) {
          let tmp = bbn.fn.getField(this.source.options, 'text', {value: row.id_type});
          if (tmp) {
            res = tmp;
          }
        }

        return res;
      },
      getOption(row) {
        return row.option_name || '-';
      },
      getResume(row) {
        let st = bbn._('Created') + ' ' + bbn.fn.fdate(row.creation) + ' ' + bbn._("by") + ' ';
        let creator = bbn.fn.getField(this.users, 'text', {value: row.creator});
        st += creator || bbn._("Unknown user");
        if (row.last_edit && (row.last_edit !== row.creation)) {
          st += '<br>' + bbn._("Last edit") + ' ' + bbn.fn.fdate(row.creation);
          if (row.id_user && (row.id_user !== row.creator)) {
            st += ' ' + bbn._("by") + ' ';
            let editor = bbn.fn.getField(this.users, 'text', {value: row.id_user});
        		st += editor || bbn._("Unknown user");
          }
        }

        return st;
      },
      markdown(row){
        bbn.fn.log('roooooooooooooooooow')
        if(row){
          bbn.fn.link('notes/form_markdown/' + row.id);
        }
        else{
          bbn.fn.link('notes/form_markdown/');
        }
      },
      rte(row){
        bbn.fn.link('notes/form_rte/' + row.id_note);
      },
      insert(){
        this.getPopup().open({
            width: 800,
            height: 600,
            title: bbn._("New Note") ,
            component: 'apst-adherent-form-note',
        })
      },
      edit(row){
        return this.$refs.table.edit(row, bbn._("Editing a mailing"));
      },
      creator(row){
        return  appui.getUserName(row.creator);
      },
      last_mod_user(row){
        return  appui.getUserName(row.id_user);
      },
      title(row){
        //return row.title
        if (!row.title || (row.title === '') && row.excerpt) {
          return row.excerpt.substring(0, 50) + this.span;
        }
        else{
          return row.title
        }
      }
    },
    components: {
      'apst-notes-content': {
        template: '#apst-notes-content',
        props: ['source'],
        methods: {

        }
      },
      'apst-new-note': {
        template: '#apst-new-note',
        props: ['source'],
        methods: {

        }
      },
    }
  }
})();