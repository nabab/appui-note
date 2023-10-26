<?php
if ($model->hasData(['text', 'code'], true)) {
  $cmsCls = new \bbn\Appui\Cms($model->db);
  if ($idType = $cmsCls->insertType($model->data)) {
    return [
      'success' => true,
      'data' => $model->inc->options->option($idType)
    ];
  }
}

return ['success' => false];
