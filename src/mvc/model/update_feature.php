<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;
use bbn\Str;
/** @var $model \bbn\Mvc\Model*/

if ($model->hasData(["id_option", "id_note"], true)) {
	$note = new bbn\Appui\Note($model->db);
  $note->addFeature($model->data["id_option"], $model->data["id_note"]);
  return [
    "success" => true
  ];
}
