<?php
/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 20/07/17
 * Time: 17.09
 *
 * @var bbn\Mvc\Model $model
 */

$res = ['success' => false];

if ( !empty($model->data['title']) &&
    ($cms = new \bbn\Appui\Cms($model->db)) 
){
  $notes = new \bbn\Appui\Note($model->db);
  if( ($notes->insertVersion(
     $model->data['id_note'],
     $model->data['title'], 
     $model->data['content'])
   )  
    ){
      //if the url is not set or if it's different from the one in database it sets the url  
      if ( empty($cms->getUrl($model->data['id_note'])) || 
      ( $cms->getUrl($model->data['id_note']) !== $model->data['url'])
      ){
        if ( !empty($model->data['url'])){
          try {
            $cms->setUrl($model->data['id_note'], $model->data['url']);
          }
          catch ( \Exception $e ){
            return ['error' =>$e->getMessage()];
          }
          
        }
        //$cms->setUrl($model->data['id_note'], $model->data['url']);
      }    

      if ( empty($cms->getEvent($model->data['id_note'])) ){
        $res['success'] = $cms->setEvent($model->data['id_note'], [
        'start' => $model->data['start'], 
        'end' => $model->data['end'] 
      ]);
      }
      else {
        $res['success'] = $cms->updateEvent($model->data['id_note'], [
          //if we need the name of the event in bbn_events
        //'name' => $model->data['title'],
        'start' => $model->data['start'], 
        'end' => $model->data['end'] 
      ]);
    }    
  }
}

return $res;