<?php
if ($model->hasData(['idGroup', 'medias'], true) && is_array($model->data['medias'])) {
  $ok = 0;
  foreach ($model->data['medias'] as $idMedia) {
    $ok += $model->db->delete('bbn_medias_groups_medias', [
      'id_group' => $model->data['idGroup'],
      'id_media' => $idMedia
    ]);
  }
  return [
    'success' => $ok === count($model->data['medias'])
  ];
}
return ['success' => false];