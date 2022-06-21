<?php
$res['success'] = false; 
if($model->hasData(['note_type', 'limit', 'order'])){
  $cms = new \bbn\Appui\Cms($model->db);
  $res = $cms->getAll(false, [], [$model->data['order'] => 'desc'],$model->data['limit'],0, $model->data['note_type'] );
  $res['success'] = true; 
}
return $res;
