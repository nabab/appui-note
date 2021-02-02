<?php
$res = [
  'success' => false
];
$notes = new \bbn\Appui\Note($model->db);
$cms = new \bbn\Appui\Cms($model->db);

if ( !empty($model->data['id']) ){
  $res['success'] = $cms->delete($model->data['id']);
}
return $res;