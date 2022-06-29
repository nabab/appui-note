<?php
/**
 * What is my purpose?
 *
 **/
use bbn\Appui\Note;

/** @var $model \bbn\Mvc\Model*/

if ($model->hasData('filters', true) && !empty($model->data['filters']['conditions']) && !empty($model->data['filters']['conditions'][0]['value'])) {
  $note = new Note($model->db);
  $cfg = $note->getLastVersionCfg();
  $cfg['where']['conditions'][] = [
    'field' => 'title',
    'operator' => 'contains',
    'value' => $model->data['filters']['conditions'][0]['value']
  ];
  if (!empty($model->data['types']) && is_array($model->data['types'])) {
    $idx = count($cfg['where']['conditions']);
    $tmp = [];
    foreach ($model->data['types'] as $type) {
      $tmp[] = [
        'field' => 'id_type',
        'value' => $type
      ];
    }
    if (count($tmp) > 1) {
      $cfg['where']['conditions'][] = [
        'logic' => 'OR',
        'conditions' => $tmp
      ];
    }
    else {
      $cfg['where']['conditions'][] = $tmp[0];
    }
  }

  return [
    'cfg' => $cfg,
    'success' => true,
    'data' => $model->db->rselectAll($cfg)
  ];
}
