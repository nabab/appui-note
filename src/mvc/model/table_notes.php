<?php

use \bbn\Appui\Note;
if ( $model->hasData('limit', true)) {
  $notes = new Note($model->db);
  return $notes->browse($model->data);
}
if ( $model->hasData('action', true)) {
  $notes = new Note($model->db);
  if ($model->hasData(['id', 'id_type'], true)) {
    return ['success' => $notes->setType($model->data['id'], $model->data['id_type'])];
  }
}
return ['options' => Note::getOptionsTextValue('types')];
