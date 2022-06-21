<?php
$res['success'] = false; 
if($model->hasData(['mode', 'limit', 'order'])){
  if(($mode = $model->data['mode'])){
    if(($mode === 'publications') && isset($model->data['note_type'])){
      $cms = new \bbn\Appui\Cms($model->db);
      $res = $cms->getAll(false, [], [$model->data['order'] => 'desc'],$model->data['limit'],0, $model->data['note_type'] );
      $res['success'] = true; 
    }
    if(($mode === 'gallery') && ($id_group = $model->data['id_group'])){
      $medias = new \bbn\Appui\Medias($model->db);
      $res = $medias->browseByGroup($id_group, ['limit' => $model->data['limit']]);
      $res['success'] = true; 
    }
    
  }
  
}
return $res;
