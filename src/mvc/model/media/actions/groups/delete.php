<?php
if ($model->hasData('id', true)) {
  $model->db->delete('bbn_medias_groups_medias', ['id_group' => $model->data['id']]);
  return [
    'success' => (bool)$model->db->delete('bbn_medias_groups', ['id' => $model->data['id']])
  ];
}
return ['success' => false];