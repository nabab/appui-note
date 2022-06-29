<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;
use bbn\Str;
/** @var $model \bbn\Mvc\Model*/

if ($model->hasData('id_option', true)) {
  $note = new bbn\Appui\Note($model->db);
  return [
    "data" => $note->getFeatures($model->data['id_option']),
    "success" => true
  ];
}
