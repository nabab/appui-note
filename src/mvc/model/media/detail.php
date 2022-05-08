<?php
if ($model->hasData('id', true)) {
  $cms = new \bbn\Appui\Cms($model->db);
  $media = $cms->getMedia($model->data['id'], true);
  return [
    'media' => $media
  ];
}
return [];