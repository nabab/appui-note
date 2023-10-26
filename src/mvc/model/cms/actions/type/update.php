<?php
if ($model->hasData(['id', 'text', 'code'], true)) {
  $cmsCls = new \bbn\Appui\Cms($model->db);
  if ($idType = $cmsCls->updateType($model->data['id'], $model->data)) {
    return [
      'success' => true,
      'data' => $model->inc->options->option($idType)
    ];
  }
}

return ['success' => false];
