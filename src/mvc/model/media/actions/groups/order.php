<?php
$success = false;
if ($model->hasData(['idGroup', 'idMedias'], true)) {
  $success = true;
  foreach ($model->data['idMedias'] as $id => $pos) {
    if (!isset($pos)
      || !$model->db->update('bbn_medias_groups_medias', [
        'position' => null
      ], [
        'id_group' => $model->data['idGroup'],
        'id_media' => $id
      ])
    ) {
      $success = false;
    }
  }
  foreach ($model->data['idMedias'] as $id => $pos) {
    if (!isset($pos)
      || !$model->db->update('bbn_medias_groups_medias', [
        'position' => $pos
      ], [
        'id_group' => $model->data['idGroup'],
        'id_media' => $id
      ])
    ) {
      $success = false;
    }
  }
}
return ['success' => $success];