/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 06/03/2018
 * Time: 16:36
 */

(() => {
  return {
    props: ['source'],
    computed: {
      userName(){
        return appui.getUserName(this.source.id_user);
      },
      creationDate(){
        return bbn.dt(this.source.creation).format('DD/MM/YYYY');
      },
      creationTime(){
        return bbn.dt(this.source.creation).format('HH:mm');
      }
    }
  }
})();
