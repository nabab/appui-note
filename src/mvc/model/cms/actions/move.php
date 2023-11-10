<?php
$suc = [
  'success' => false
];
if ($model->hasData(['id', 'type'], true)) {
  $cms = new \bbn\Appui\Cms($model->db);
  if (is_array($model->data['id'])) {
    $suc['success'] = true;
    foreach ($model->data['id'] as $id) {
      if (!$cms->setType($id, $model->data['type'])) {
        $suc['message'] = _("One or more posts could not be moved in category");
      }
    }
  }
  else {
    $suc['success'] = (bool)$cms->setType($model->data['id'], $model->data['type']);
  }
}

return $res;
