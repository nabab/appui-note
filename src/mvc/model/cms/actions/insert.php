<?php
/** @var \bbn\Mvc\Model $model */

$res = ['success' => false];

if ( !empty($model->data['title']) &&
    ($cms = new \bbn\Appui\Cms($model->db)) &&
    ($url = $model->data['url'])
){
  $notes = new \bbn\Appui\Note($model->db);
  //the note has to be type 'pages'
  $type = $model->inc->options->fromCode('pages', 'types', 'note', 'appui');
  if ( $note = $notes->insert(
        $model->data['title'], 
        $model->data['content'], 
    	  $type
      ) 
  ){
    if ( !empty($model->data['url'])){
      try {
        $cms->setUrl($note, $model->data['url']);
      }
      catch ( \Exception $e ){
        return ['error' => $e->getMessage()];
      }
    }
    //links each of the files selected from browser to the note
    if ( !empty($model->data['files']) ){
      //the version of the note is clearly 1, we're inserting the note
      foreach($model->data['files'] as $file){
        $notes->addMediaToNote($file['id'], $note, 1);
      }
    }
    //cms->publish will also set the url if it's not already set 
    if ( $cms->setEvent($note, [
      'start' => $model->data['start'], 
      'end' => $model->data['end'] 
    ])){
      $res['success'] = !empty($cms->get($url));      
    }
  }
}

return $res;