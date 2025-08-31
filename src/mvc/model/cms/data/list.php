<?php

/** @var bbn\Mvc\Model $model */


if ($model->hasData(['start', 'limit'])) {
  $cms = new \bbn\Appui\Cms($model->db);
  return $cms->getAll(false, $model->data['filters'] ?? [], $model->data['order'] ?? [], $model->data['limit'], $model->data['start']);
}
