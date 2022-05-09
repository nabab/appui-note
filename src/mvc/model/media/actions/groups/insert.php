<?php
if ($model->hasData(['idGroup', 'medias'], true) && is_array($model->data['medias'])) {
  $medias = new bbn\Appui\Medias($model->db);
  $ok = 0;
  foreach ($model->data['medias'] as $idMedia) {
    // Adding with tag
    $ok += (int)$medias->addToGroup($idMedia, $model->data['idGroup'], true);
  }

  return [
    'success' => !!$ok
  ];
}
return ['success' => false];