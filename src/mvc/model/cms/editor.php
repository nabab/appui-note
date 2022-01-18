<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

if ($model->hasData('id', true)) {
  $note = new bbn\Appui\Note($model->db);
  $cms = new bbn\Appui\Cms($model->db, $note);
  $data = $cms->get($model->data['id']);
  $data['items'] = $data['content'] ? json_decode($data['content']) : [];
  unset($data['content']);
  return ['data' => $data, 'types' => $note->getOptions('types'), 'title' => $data['title']];
}
