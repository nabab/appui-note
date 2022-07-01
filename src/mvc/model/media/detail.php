<?php
if ($model->hasData('id', true)) {
  $cms = new \bbn\Appui\Cms($model->db);
  $media = $cms->getMedia($model->data['id'], true);
  if (!empty($media['url'])) {
    $cacheFiles = array_map(function($f){
      return [
        'file' => str_replace(BBN_PUBLIC, '', $f),
        'name' => basename($f),
        'modified' => filemtime($f)
      ];
    }, \bbn\File\Dir::getFiles(BBN_PUBLIC . dirname($media['url'])));
    $media['cacheFiles'] = $cacheFiles;
  }
  return [
    'media' => $media
  ];
}
return [];