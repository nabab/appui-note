<?php
if ($model->hasData(['id', 'text'], true)) {
  $medias = new bbn\Appui\Medias($model->db);
  return ['success' => $medias->renameGroup($model->data['id'], $model->data['text'])];
}

return ['success' => false];
