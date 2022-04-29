<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Model*/

if ($model->hasData('cat', true)) {
  if ($id_opt = $model->inc->options->fromCode($model->data['cat'], 'types', 'note', 'appui')) {
    $notes = new \bbn\Appui\Note($model->db);
    $cms = new \bbn\Appui\Cms($model->db);
    if ($model->hasData(['start', 'limit'])) {
      return $cms->getAll(false, $model->data['filters'] ?? [], $model->data['order'] ?? [], $model->data['limit'], $model->data['start'], $id_opt);
    }
    else {
      return [
        'types' => $cms->getTypes(),
        'cat' => $model->data['cat'],
        'id_type' => $id_opt
      ];
    }
  }
}
