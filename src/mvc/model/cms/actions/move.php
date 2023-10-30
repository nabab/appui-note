<?php
$suc = false;
if ($model->hasData(['id', 'type'], true)) {
  $cms = new \bbn\Appui\Cms($model->db);
  if (is_array($model->data['id'])) {
    $suc = true;
    foreach ($model->data['id'] as $id) {
      if (!$cms->setType($id, $model->data['type'])) {
        $suc = false;
      }
    }
  }
  else {
    $suc = (bool)$cms->setType($model->data['id'], $model->data['type']);
  }
}

return ['success' => $suc];
