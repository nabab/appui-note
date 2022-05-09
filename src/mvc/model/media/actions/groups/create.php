<?php
if ($model->hasData('text', true)) {
  $medias = new bbn\Appui\Medias($model->db);
  if ($id_group = $medias->createGroup($model->data['text'])) {
    return [
      'success' => true,
      'data' => [
        'id' => $id_group
      ]
    ];
  }
}

return ['success' => false];
