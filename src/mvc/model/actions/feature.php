<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;
use bbn\Str;
/** @var $model \bbn\Mvc\Model*/

if ($model->hasData('action')) {
  $note = new bbn\Appui\Note($model->db);
  switch ($model->data['action']) {
    case 'add_feature':
      if ($model->hasData(['id_option', 'id_note', 'num'], true)) {
        $note = new bbn\Appui\Note($model->db);
        $feature = $note->addFeature($model->data['id_option'], $model->data['id_note'], null, $model->data['num']);
        return [
          'feature' => $feature,
          'success' => true
        ];
      }
      break;
    case 'delete':
      if ($model->hasData(['id_option'], true)) {
        $note = new bbn\Appui\Note($model->db);
        $data = $note->removeFeature($model->data['id_option']);
        return [
          'data' => $data,
          'success' => true
        ];
      }
      break;
    case 'order':
      if ($model->hasData(['id', 'num'], true)) {
        $data = $note->setFeatureOrder($model->data['id'], $model->data['num']);
        return [
          "data" => $data,
          'success' => true
        ];
      }
      break;
    case 'update':
      if ($model->hasData(['id', 'text', 'code', 'orderMode'], true)) {
        return [
          'success' => $model->inc->options->set($model->data['id'], [
            'text' => $model->data['text'],
            'code' => $model->data['code'],
            'orderMode' => $model->data['orderMode']
          ])
        ];
      }
      break;
    case 'add_category':
      if ($model->hasData(['text', 'code'], true)) {
        $id_option = $model->inc->options->add([
          'text' => $model->data['text'],
          'code' => $model->data['code'],
          'id_parent' => $model->inc->options->fromCode(['features', 'note', 'appui'])
        ]);
        return [
          'success' => (bool)$id_option,
          'data' => $id_option ? $model->inc->options->option($id_option) : null
        ];
      }
      break;
  }
}