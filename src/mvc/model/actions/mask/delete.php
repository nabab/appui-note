<?php

/** @var bbn\Mvc\Model $model */
if ( !empty($model->data['id_note']) ){
  $mask = new \bbn\Appui\Masks($model->db);
  $model->data['res']['success'] = $mask->delete($model->data['id_note']);
}
return $model->data['res'];