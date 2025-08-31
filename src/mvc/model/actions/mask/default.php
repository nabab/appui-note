<?php

/** @var bbn\Mvc\Model $model */
$masks = new \bbn\Appui\Masks($model->db);
if ( isset($model->data['id_note']) ){
  $model->data['res']['success'] = $masks->setDefault($model->data['id_note']);
}
return $model->data['res'];