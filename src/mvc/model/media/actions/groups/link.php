<?php
if($model->hasData(['link', 'id', 'id_group'])){
  $res['success'] = $model->db->update('bbn_medias_groups_medias', ['link' => $model->data['link']],[
    'id_media' => $model->data['id'],
    'id_group' => $model->data['id_group']
  ]);
  return $res;
}
