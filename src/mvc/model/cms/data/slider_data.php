<?php
$res = ['success' => false];
if ($model->hasData(['mode', 'limit', 'order'])) {
  if (($mode = $model->data['mode'])) {
    if (($mode === 'publications') && isset($model->data['note_type'])) {
      $filter = [];
      if($model->data['note_type'] === 'news'){
        $model->data['note_type'] = null;
      }
      if($model->hasData(['id_option'])){
        $filter = [
          'id_option' =>  $model->data['id_option']
        ];
      }
      $cms = new \bbn\Appui\Cms($model->db);
      $res = $cms->getAll(false, $filter, [$model->data['order'] => 'desc'],$model->data['limit'],0, $model->data['note_type'] );
      $res['success'] = true;
    }
    elseif (($mode === 'gallery') && ($id_group = $model->data['id_group'])) {
      $medias = new \bbn\Appui\Medias($model->db);
      $res = $medias->browseByGroup($id_group, ['limit' => $model->data['limit']]);
      $res['success'] = true;
    }
    elseif (($mode === 'features') && $model->hasData('id_feature', true)) {
      $note = new bbn\Appui\Note($model->db);
      $res['data'] = $note->getFeatures($model->data['id_feature']);
      $res['success'] = true;
    }
  }
}

return $res;
