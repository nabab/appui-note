<?php
/** @var $model \bbn\Mvc\Model*/
if ($model->hasData('limit', true) && $model->hasData('start')) {
  $medias = new \bbn\Appui\Medias($model->db);
  return $medias->browse($model->data);
}