<?php
if ($model->hasData('text', true)
  && $model->db->insert('bbn_medias_groups', ['text' => $model->data['text']])
) {
  return [
    'success' => true,
    'data' => [
      'id' => $model->db->lastId()
    ]
  ];
}
return ['success' => false];