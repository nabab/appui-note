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
        return dayjs(this.source.creation).format('DD/MM/YYYY');
      },
      creationTime(){
        return dayjs(this.source.creation).format('HH:mm');
      }
    }
  }
})();
