<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Model*/


if ($model->hasData(['start', 'limit'])) {
  $db = new \bbn\Db();
  $opt = new \bbn\Appui\Option($db);
  $notes = new \bbn\Appui\Note($db);
  $cms = new \bbn\Appui\Cms($model->db);
  return $cms->getAll(false, $model->data['filters'] ?? [], $model->data['order'] ?? [], $model->data['limit'], $model->data['start']);
}
