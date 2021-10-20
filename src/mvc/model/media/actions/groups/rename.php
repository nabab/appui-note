<?php
if ($model->hasData(['id', 'text'], true)
  && $model->db->update('bbn_medias_groups', ['text' => $model->data['text']], ['id' => $model->data['id']])
) {
  return ['success' => true];
}
return ['success' => false];