<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Model*/


$db = new \bbn\Db();
$opt = new \bbn\Appui\Option($db);
$notes = new \bbn\Appui\Note($db);
$cms = new \bbn\Appui\Cms($model->db);
if ($model->hasData(['start', 'limit'])) {
  return $cms->getAll(false, $model->data['filters'] ?? [], $model->data['order'] ?? [], $model->data['limit'], $model->data['start']);
}
else {
  return ['types' => $cms->getTypes()];
}
