<?php
use bbn\Str;
use bbn\Appui\Note;

if ($model->hasData(['data'])) {
  $notes = new Note($model->db);
  return [
    'data' => $notes->getPostIts($model->data)
  ];
}
