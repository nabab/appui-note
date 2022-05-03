<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Model*/

if ($model->hasData('cat', true)) {
  if ($opt = $model->inc->options->option($model->data['cat'], 'types', 'note', 'appui')) {
    $notes = new \bbn\Appui\Note($model->db);
    $cms = new \bbn\Appui\Cms($model->db);
    if ($model->hasData(['start', 'limit'])) {
      return $cms->getAll(false, $model->data['filters'] ?? [], $model->data['order'] ?? [], $model->data['limit'], $model->data['start'], $opt['id']);
    }
    else {
      $options = [];
      if (!empty($opt['id_root_alias'])) {
        $options = $model->inc->options->textValueOptions($opt['id_root_alias']);
      }
      return [
        'cat' => $model->data['cat'],
        'id_type' => $opt['id'],
        'options' => $options
      ];
    }
  }
}
