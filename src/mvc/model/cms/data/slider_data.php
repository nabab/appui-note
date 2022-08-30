<?php
$res = ['success' => false];
if ($model->hasData(['mode', 'limit', 'order'])) {
  if (($mode = $model->data['mode'])) {
    if (($mode === 'publications') && isset($model->data['note_type'])) {
      $filter = [];
      if($model->data['note_type'] === 'news'){
        $model->data['note_type'] = null;
        $filter['conditions'] = [];
        $filter['conditions'][] = [
          'field' => 'start',
          'operator' => '<=',
          'value' => date('Y-m-d H:i:s')
        ];
        $filter['conditions'][] = [
          'logic' => 'OR',
          'conditions' => [
            [
              'field' => 'end',
              'operator' => '>=',
              'value' => date('Y-m-d H:i:s')
          ], [
             'field' => 'end',
             'operator' => 'isnull'
          ]
        ]];
        //all types except for pages
        $filter['conditions'][] = [
          'field' => 'id_type',
          'operator' => '!=',
          'value' => $model->inc->options->fromCode('pages','types','note','appui'),
        ];
      }
      //if type === authors and a period is selected
      if($model->hasData(['id_option'])){
        $filter['conditions'][] = [
          'field' => 'id_option',
          'value' => $model->data['id_option'],
          'operator'=> '='
        ];
      }
      
      $cms = new \bbn\Appui\Cms($model->db);
      $res = $cms->getAll(false, $filter, [$model->data['order'] => 'desc'], $model->data['limit'],0, $model->data['note_type'] );
      
      $res['success'] = true;
    }
    elseif (($mode === 'gallery') && ($id_group = $model->data['id_group'])) {
      $medias = new \bbn\Appui\Medias($model->db);
      $res = $medias->browseByGroup($id_group, ['limit' => $model->data['limit']]);
      $res['success'] = true;
    }
    elseif (($mode === 'features') && $model->hasData('id_feature', true)) {
      $note = new bbn\Appui\Note($model->db);
      $res['data'] = $note->getFeatures($model->data['id_feature'], true);
      $res['success'] = true;
    }
  }
}

return $res;
