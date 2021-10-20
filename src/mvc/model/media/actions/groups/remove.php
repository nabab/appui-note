<?php
if ($model->hasData(['id_group', 'id_media'], true)) {
  return [
    'success' => (bool)$model->db->delete('bbn_medias_groups_medias', [
      'id_group' => $model->data['id_group'],
      'id_media' => $model->data['id_media']
    ])
  ];
}
return ['success' => false];