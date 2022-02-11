<?php
if ($model->hasData('id', true)) {
  $medias = new \bbn\Appui\Medias($model->db);
  $media = $medias->getMedia($model->data['id'], true);
  return [
    'media' => $media
  ];
}
return [];