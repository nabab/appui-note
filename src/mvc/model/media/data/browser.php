<?php
/** @var bbn\Mvc\Model $model */

if ($model->hasData('limit', true) && $model->hasData('start')) {
  $medias = new \bbn\Appui\Medias($model->db);
  $model->data['order'] = [['field'=>'last_mod', 'dir' => 'DESC']];

  return $medias->browse($model->data);
}