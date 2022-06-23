<?php
if ($model->hasData('id', true) && $model->hasData('pinned')) {
  $note = new \bbn\Appui\Note($model->db);
  if (!empty($model->data['pinned'])) {
    return ['success' => $note->pin($model->data['id'])];
  }
  return ['success' => $note->unpin($model->data['id'])];
}
return ['success' => false];