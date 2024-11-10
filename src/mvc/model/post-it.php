<?php
/** @var bbn\Mvc\Model $model */
$notes = new \bbn\Appui\Note($model->db);
return [
  'notes' => $notes->getByType(
    $model->inc->options->fromCode('personal', 'types', 'note', 'appui'),
    $model->inc->user->getId()
  )
];
