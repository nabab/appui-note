<?php
if ($model->hasData(['idGroup', 'medias'], true) && is_array($model->data['medias'])) {
  $ok = 0;
  foreach ($model->data['medias'] as $idMedia) {
    $ok += $model->db->insertIgnore('bbn_medias_groups_medias', [
      'id_group' => $model->data['idGroup'],
      'id_media' => $idMedia
    ]);
  }
  return [
    'success' => !!$ok
  ];
}
return ['success' => false];