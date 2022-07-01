<?php
if ($model->hasData('id', true)) {
  $cms = new \bbn\Appui\Cms($model->db);
  return [
    'success' => $cms->clearCache($model->data['id'])
  ];
}
return ['success' => false];