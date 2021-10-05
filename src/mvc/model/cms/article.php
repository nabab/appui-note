<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

if ($model->hasData('id', true)) {
  $data = $model->db->select('articles', ['bbn_cfg', 'title', 'url'], ['id' => $model->data['id']]);
  $items = $data->bbn_cfg ? json_decode($data->bbn_cfg) : [];
  return [
    'items' => $items,
  	'title' => $data->title
  ];
}
