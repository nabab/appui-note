<?php
/*
 * Describe what it does!
 *
 **/
/** @var $this \bbn\Mvc\Model*/
if ( !empty($model->data['id_note']) ){
  $notes = new \bbn\Appui\Note($model->db);
  $note = $notes->get($model->data['id_note']);

	if ( !empty($model->data['id_type']) ){
    $note['id_type'] = $model->data['id_type'];
    $note['default'] = $model->data['default'];
    $note['type'] =  $model->data['type'];
  }
  return [
    'note' => $note,
    'success' => true,
  ];
}
return ['success' => false];
