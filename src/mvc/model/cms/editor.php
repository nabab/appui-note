<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

if ($model->hasData('id', true)) {
  $note = new bbn\Appui\Note($model->db);
  $data = $note->get($model->data['id']);
  $data['url'] = $note->getUrl($model->data['id']);
  $cms = new bbn\Appui\Cms($model->db, $note);
  $data['start'] = $cms->getStart($model->data['id']);
  $data['end'] = $cms->getEnd($model->data['id']);
  $data['items'] = $data['content'] ? json_decode($data['content']) : [];
  $data['mediasGroups'] = $model->db->rselectAll('bbn_medias_groups');
  unset($data['content']);
  return $data;
}
