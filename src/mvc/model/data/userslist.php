<?php
use bbn\Appui\Note;
use bbn\Mvc\Model;

/** @var Model $model */
if ($model->hasData('id', true)) {
  $notes = new Note($model->db);
  $classCfg = $notes->getClassCfg();
  return [
    'success' => true,
    'data' => explode(',', $model->db->selectOne([
      'table' => $classCfg['tables']['versions'],
      'fields' => 'GROUP_CONCAT(DISTINCT LOWER(HEX('.$classCfg['arch']['versions']['id_user'].')) SEPARATOR ",")',
      'where' => [
        $classCfg['arch']['versions']['id_note'] => $model->data['id']
      ],
      'group' => $classCfg['arch']['versions']['id_note']
    ]))
  ];
}

return ['success' => false];
