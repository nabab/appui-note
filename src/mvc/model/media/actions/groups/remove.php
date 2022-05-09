<?php
if ($model->hasData(['idGroup', 'medias'], true) && is_array($model->data['medias'])) {
  $ok = 0;
  $medias = new bbn\Appui\Medias($model->db);
  foreach ($model->data['medias'] as $idMedia) {
    $ok += (int)$medias->removeFromGroup($idMedia, $model->data['idGroup']);
  }
  return [
    'success' => $ok === count($model->data['medias'])
  ];
}
return ['success' => false];