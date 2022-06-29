<?php
/**
 * What is my purpose?
 *
 **/
use bbn\Appui\Cms;

/** @var $model \bbn\Mvc\Model*/

if ($model->hasData('filters', true) && !empty($model->data['filters']['conditions']) && !empty($model->data['filters']['conditions'][0]['value'])) {
  $note = new Cms($model->db);
  $where = [
    [
      'field' => 'title',
      'operator' => 'contains',
      'value' => $model->data['filters']['conditions'][0]['value']
    ]
  ];
  if (!empty($model->data['types']) && is_array($model->data['types'])) {
    $idx = count($where);
    $tmp = [];
    foreach ($model->data['types'] as $type) {
      $tmp[] = [
        'field' => 'id_type',
        'value' => $type
      ];
    }
    if (count($tmp) > 1) {
      $where[] = [
        'logic' => 'OR',
        'conditions' => $tmp
      ];
    }
    else {
      $where[] = $tmp[0];
    }
  }
  $cfg = $note->getLastVersionCfg(false, false, $where);
  return [
    'cfg' => $cfg,
    'success' => true,
    'data' => $model->db->rselectAll($cfg)
  ];
}
