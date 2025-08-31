<?php
/** @var bbn\Mvc\Model $model */

$res = ['success' => false];

if ($model->hasData(['title', 'type'], true)) {
  $notes = new \bbn\Appui\Note($model->db);
  $cms = new \bbn\Appui\Cms($model->db);
  //the note has to be type 'pages'
  if ($note = $notes->insert(
    $model->data['title'],
    '[]',
    $model->data['type'],
    false,
    false,
    null,
    null,
    'json/bbn-cms',
    $model->data['lang'],
  )
  ) {
    if (!empty($model->data['url'])) {
      try {
        $cms->setUrl($note, $model->data['url']);
      }
      catch ( \Exception $e ){
        return ['error' => $e->getMessage()];
      }
      

      $res['success'] = true;
      $res['data'] = [
        'id_note' => $note
      ];
    }
    /*
    //links each of the files selected from browser to the note
    if (!empty($model->data['files'])) {
      //the version of the note is clearly 1, we're inserting the note
      foreach($model->data['files'] as $file){
        $notes->addMediaToNote($file['id'], $note, 1);
      }
    }
    //cms->publish will also set the url if it's not already set
    if ($cms->setEvent($note, [
      'start' => $model->data['start'],
      'end' => $model->data['end']
    ])) {
      $res['success'] = !empty($note);
      $res['data'] = $note;
    }
    */
  }
  else {
    $res['error'] = _("Impossible to create the note");
  }
}

return $res;