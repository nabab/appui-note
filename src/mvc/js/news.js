/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 06/03/2018
 * Time: 15:53
 */
(() => {
  return {
    props: ['source'],
    data(){
      return {
        users: bbn.fn.order(appui.users, 'text', 'ASC'),
      }
    },
    methods: {
      insert(){
        this.$refs.table.insert({}, {
          label: bbn._('New message'),
          width: '70%',
          height: '70%'
        });
      },
      edit(row, col, idx){
        this.$refs.table.edit(row, {
          label: bbn._('Edit message'),
          width: 800,
          height: 600
        }, idx);
      },
      see(row){
        this.getPopup({
          label: row.title,
          width: 800,
          height: 600,
          component: 'appui-note-popup-note',
          source: row
        });
      }
    },
    components: {
      'appui-note-news-new': {
        props: ['source'],
        data(){
          return {
            root: appui.plugins['appui-note'],
          }
        },
        template: '#appui-note-news-new',
        methods: {
          checkDate(){
            if ( (this.source.row.end.length === 0) ||
              (this.source.row.start < this.source.row.end)
            ){
              return true;
            }
            else{
              return false;
            }
          },
          success(d){
            if ( d. success ){
              appui.success(bbn._('Saved'));
              this.closest('bbn-container').getComponent().getRef('table').updateData();
            }
            else {
              appui.error(bbn._('Error'));
            }
          }
        }
      }
    }
  };
})();
